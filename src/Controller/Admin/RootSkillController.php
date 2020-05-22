<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Entity\Skill;
use App\Form\RootSkillType;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/rootskill")
 */
class RootSkillController extends AbstractController
{
    /**
     * @Route("/", name="skill_index", methods={"GET"})
     */
    public function index(SkillRepository $skillRepository): Response
    {
        return $this->render('admin/skill/index.html.twig', [
            'skills' => $skillRepository->getRootSkills(),
        ]);
    }

    /**
     * @Route("/new", name="skill_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $skill = new Skill();
        $skill->setParentId(Skill::ROOT_SKILL);
        $form = $this->createForm(RootSkillType::class, $skill);
        $form->handleRequest($request);

        $question = $this->getQuestion();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $skill->setPath('|' . Skill::ROOT_SKILL . '|');
            $skill->setQuestion($question);
            $skill->setParentId(Skill::ROOT_SKILL);
            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('skill_index');
        }

        return $this->render('admin/skill/new.html.twig', [
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="skill_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Skill $skill): Response
    {
        $skill->setParentId(Skill::ROOT_SKILL);

        $form = $this->createForm(RootSkillType::class, $skill);
        $form->handleRequest($request);
        $question = $this->getQuestion();
        $skill->setQuestion($question);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('skill_index');
        }

        return $this->render('admin/skill/edit.html.twig', [
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="skill_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Skill $skill): Response
    {
        if ($this->isCsrfTokenValid('delete' . $skill->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($skill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('skill_index');
    }

    /**
     * @return \Doctrine\Persistence\ObjectRepository|object|null
     */
    protected function getQuestion()
    {
        return $this->getDoctrine()->getManager()->getRepository(Question::class)->find(1);
    }
}
