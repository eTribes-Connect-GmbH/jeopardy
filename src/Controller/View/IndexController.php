<?php declare(strict_types = 1);

namespace App\Controller\View;

use App\Entity\Skill;
use App\Entity\SkillResultIndex;
use App\Entity\UserResultIndex;
use App\Repository\SkillRepository;
use App\Security\UserDataTrait;
use App\View\ViewListServiceInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/view")
 */
class IndexController extends AbstractController
{
    use UserDataTrait;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $em;

    /**
     * @var \App\View\ViewListServiceInterface
     */
    protected $viewListService;

    /**
     * IndexController constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     * @param \App\View\ViewListServiceInterface $viewListService
     */
    public function __construct(EntityManagerInterface $em, ViewListServiceInterface $viewListService)
    {
        $this->em = $em;
        $this->viewListService = $viewListService;
    }

    /**
     * @Route("/user", name="view_user", methods={"GET"})
     */
    public function user(Request $request)
    {
        return $this->render('view/user.html.twig', [
            'user' => $this->getUserData($request),
            'skills' => $this->getSkillRepository()->getTree()
        ]);
    }

    /**
     * @Route("/", name="view_index", methods={"GET"})
     * @Route("/skill/{id}", name="view_skill", methods={"GET"})
     */
    public function skill(Request $request, ?int $id = 1)
    {
//        /** @var SkillResultIndex|null $resultIndex */
//        $resultIndex = $this->em->getRepository(SkillResultIndex::class)->getResultIndexWithUsers($id);
//        /** @var Skill $skill */
        $skill = $this->em->getRepository(Skill::class)->find($id);
//        $tree = $this->getSkillRepository()->getTree($skill->getId());
//        $firstUser = $resultIndex->getUsers()->first();

        $viewList = $this->viewListService->getSkillListView($id);

        return $this->render('view/skill.html.twig', [
            'user' => $this->getUserData($request),
            'viewResult' => $viewList,
            'skill' => $skill,
            'breadCrumb' => $this->createBreadCrumb($skill)
        ]);
    }

    /**
     * @return \App\Repository\SkillRepository
     */
    protected function getSkillRepository(): SkillRepository
    {
        return $this->em->getRepository(Skill::class);
    }

    protected function createBreadCrumb(Skill $skill)
    {
        $path = $skill->getPath() ?? '';

        $parts = explode('|', $path);
        $parts = array_filter($parts);

        /** @var \Doctrine\ORM\QueryBuilder $query */
        $query = $this->em->getRepository(Skill::class)->createQueryBuilder('skill');
        $query->where($query->expr()->in('skill.id', ':ids'));
        $query->setParameter('ids', $parts, Connection::PARAM_INT_ARRAY);

        $data = [];
        /** @var Skill $value */
        foreach ($query->getQuery()->getResult() as $value) {
            $data[$value->getId()] = [
                'path' => $this->generateUrl('view_skill', ['id' => $value->getId()]),
                'name' => $value->getName(),
            ];
        }
        return $data;
    }
}