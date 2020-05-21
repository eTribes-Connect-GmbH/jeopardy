<?php declare(strict_types = 1);

namespace App\Controller\Content;

use App\Entity\Question;
use App\Entity\Skill;
use App\Form\SkillType;
use App\Security\UserDataTrait;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/content/skillbuilder")
 */
class SkillBuilderController extends AbstractController
{
    private const ROOT_SKILL = 0;

    use UserDataTrait;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * SkillBuilder constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/skillbuilder", name="skill_builder_tree", methods={"GET"})
     * @Route("/skillbuilder/{id}", name="skill_builder_tree_list", methods={"GET"})
     */
    public function tree(Request $request, ?int $id)
    {
        if ($id !== null) {
            /** @var Skill $skill */
            $skill = $this->em->getRepository(Skill::class)->find($id);
            $skills = $this->getSkills($id);
            if ($skill->getParentId() > 0) {
                $path = $skill->getParent()->getPath();
                $skill->setPath($path . $skill->getParent()->getId() . '|');
            }
        } else {
            $skill = new Skill();
            $skill->setParentId(static::ROOT_SKILL);
            $skills = $this->getSkills(static::ROOT_SKILL);
        }

        return $this->render('content/skill-builder/tree.html.twig',
            [
                'user' => $this->getUserData($request),
                'skills' => $skills,
                'skill' => [
                    'name' => $skill->getName(),
                    'description' => $skill->getDescription(),
                    'id' => $skill->getId() ?? static::ROOT_SKILL,
                ],
                'breadCrumb' => $this->createBreadCrumb($skill),
                'mode' => 'list'
            ]
        );
    }

    /**
     * @Route(" /skillbuilder/{id}/edit", name="skill_builder_tree_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ?int $id)
    {
        if ($id !== null) {
            /** @var Skill $skill */
            $skill = $this->em->getRepository(Skill::class)->find($id);
            $skills = $this->getSkills($id);
            if ($skill->getParentId() > 0) {
                $path = $skill->getParent()->getPath();
                $skill->setPath($path . $skill->getParent()->getId() . '|');
            }
        } else {
            $skill = new Skill();
            $skill->setParentId(static::ROOT_SKILL);
            $skills = $this->getSkills(static::ROOT_SKILL);
        }

        $form = $this->createSkillForm($skill, $request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleForm($form);
        }

        return $this->render('content/skill-builder/tree.html.twig',
            [
                'user' => $this->getUserData($request),
                'form' => $form->createView(),
                'skills' => $skills,
                'skill' => [
                    'name' => $skill->getName(),
                    'id' => $skill->getId(),
                ],
                'breadCrumb' => $this->createBreadCrumb($skill),
                'mode' => 'edit'
            ]
        );
    }

    /**
     * @Route("/skillbuilder/{id}/new", name="skill_builder_tree_new", methods={"GET","POST"})
     */
    public function new(Request $request, ?int $id)
    {
        $skill = new Skill();
        $skill->setParentId($id);
        /** @var Skill $parent */
        $parent = $this->em->getRepository(Skill::class)->find($id);
        $skill->setParent($parent);
        $skill->setPath($parent->getPath() . $parent->getId() . '|');
        $skills = [];

        $form = $this->createSkillForm($skill, $request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleForm($form);
        }

        return $this->render('content/skill-builder/tree.html.twig',
            [
                'user' => $this->getUserData($request),
                'form' => $form->createView(),
                'skills' => $skills,
                'skill' => [
                    'name' => 'create new',
                    'id' => $parent->getId()
                ],
                'breadCrumb' => $this->createBreadCrumb($skill),
                'mode' => 'new'
            ]
        );
    }

    /**
     * @Route("/skillbuilder/{id}/delete", name="skill_builder_tree_delete", methods={"GET","POST"})
     */
    public function delete(Request $request, int $id)
    {
        /** @var Skill $skill */
        $skill = $this->em->getRepository(Skill::class)->find($id);
        $parentId = $skill->getParentId();

        if ($request->getMethod() == 'POST') {
            $this->em->remove($skill);
            $this->em->flush();
            $this->deleteChildSkills($id);

            return $this->redirectToRoute('skill_builder_tree_list', ['id' => $parentId]);
        }

        return $this->render('content/skill-builder/delete.html.twig', [
            'skill' => [
                'name' => $skill->getName(),
                'id' => $skill->getId()
            ],
            'breadCrumb' => $this->createBreadCrumb($skill)
        ]);
    }

    /**
     * @param \App\Entity\Skill $skill
     *
     * @return array
     */
    protected function getSkills(int $id): array
    {
        /** @var \Doctrine\ORM\QueryBuilder $query */
        $query = $this->em->getRepository(Skill::class)->createQueryBuilder('skill');
        $query->where($query->expr()->eq('skill.parentId', ':parentId'));
        $query->setParameter('parentId', $id);
        return $query->getQuery()->getArrayResult();
    }

    /**
     * @param \App\Entity\Skill $skill
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return mixed|\Symfony\Component\Form\FormInterface
     */
    protected function createSkillForm(Skill $skill, Request $request)
    {
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);
        return $form;
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function handleForm(\Symfony\Component\Form\FormInterface $form): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        /** @var Skill $skill */
        $skill = $form->getData();

        if($skill->getQuestionId()){
            $question = $this->em->getRepository(Question::class)->find($skill->getQuestionId());
            $skill->setQuestion($question);
        }

        $this->em->persist($skill);
        $this->em->flush();

        $this->addFlash('success', 'saved skill: ' . $skill->getName());
        return $this->redirectToRoute('skill_builder_tree_list', ['id' => $skill->getId()]);
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
                'path' => $this->generateUrl('skill_builder_tree_list', ['id' => $value->getId()]),
                'name' => $value->getName(),
            ];
        }
        return $data;
    }

    /**
     * @param int $id
     */
    protected function deleteChildSkills(int $id): void
    {
        $query = $this->em->getConnection()->createQueryBuilder();
        $query->delete('skill');
        $query->where($query->expr()->like('path', ':path'));
        $query->setParameter('path', '%|' . $id . '|%');
        $query->execute();
    }
}