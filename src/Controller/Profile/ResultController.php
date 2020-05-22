<?php declare(strict_types = 1);

namespace App\Controller\Profile;

use App\Entity\Result;
use App\Entity\Skill;
use App\Entity\User;
use App\Form\ResultType;
use App\Security\UserDataTrait;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("profile/result")
 */
class ResultController extends AbstractController
{
    use UserDataTrait;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $em;

    /**
     * ProfileController constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/{id}/new", name="result_new", methods={"GET","POST"})
     */
    public function new(Request $request, int $id): Response
    {
        $result = new Result();
        $userData = $this->getUserData($request);
        /** @var User $user */
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['email' => $userData['email']]);
        /** @var Skill $skill */
        $skill = $this->getDoctrine()->getManager()->getRepository(Skill::class)->find($id);
        $result->setSkill($skill);
        $result->setUser($user);
        $result->setQuestion($skill->getQuestion());

        $form = $this->createForm(ResultType::class, $result);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($result);
            $entityManager->flush();
            $this->addFlash('success', 'save result: ' . $result->getSkillId());

            return $this->redirectToRoute('profile_index');
        }

        return $this->render('result/new.html.twig', [
            'result' => $result,
            'form' => $form->createView(),
            'user' => $userData,
            'question' => $result->getQuestion(),
            'skill' => $result->getSkill(),
            'breadCrumb' => $this->createBreadCrumb($skill, $user->getId())
        ]);
    }

    /**
     * @Route("/{id}/edit", name="result_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Result $result): Response
    {
        $form = $this->createForm(ResultType::class, $result);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'save result: ' . $result->getSkillId());

            return $this->redirectToRoute('profile_index');
        }


        return $this->render('result/edit.html.twig', [
            'result' => $result,
            'form' => $form->createView(),
            'user' => $this->getUserData($request),
            'question' => $result->getQuestion(),
            'skill' => $result->getSkill(),
            'breadCrumb' => $this->createBreadCrumb($result->getSkill(), $result->getUserId())
        ]);
    }

    /**
     * @Route("/{id}", name="result_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Result $result): Response
    {
        if ($this->isCsrfTokenValid('delete' . $result->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            $this->addFlash('success', 'delete result: ' . $result->getSkillId());

            $entityManager->remove($result);
            $entityManager->flush();
        }

        return $this->redirectToRoute('result_index');
    }

    protected function createBreadCrumb(Skill $skill, int $userId)
    {
        $path = $skill->getPath() ?? '';

        $parts = explode('|', $path);
        $parts = array_filter($parts);

        /** @var \Doctrine\ORM\QueryBuilder $query */
        $query = $this->getDoctrine()->getManager()->getRepository(Skill::class)->createQueryBuilder('skill');
        $query->select(['skill', 'results']);
        $query->leftJoin(
            'skill.results',
            'results',
            'WITH',
            $query->expr()->andX(
                $query->expr()->eq('skill.id', 'results.skillId'),
                $query->expr()->eq('results.userId', ':userId')
            )
        );
        $query->setParameter('userId', $userId);
        $query->where($query->expr()->in('skill.id', ':ids'));
        $query->setParameter('ids', $parts, Connection::PARAM_INT_ARRAY);

        $data = [];
        /** @var Skill $value */
        foreach ($query->getQuery()->getResult() as $value) {

            $route = ($value->getResults()->count() > 0) ? 'result_edit' : 'result_new';
            $data[$value->getId()] = [
                'path' => $this->generateUrl($route, ['id' => $value->getId()]),
                'name' => $value->getName(),
            ];
        }
        return $data;
    }
}
