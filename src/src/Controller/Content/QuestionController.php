<?php

namespace App\Controller\Content;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use App\Security\UserDataTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/content/question")
 */
class QuestionController extends AbstractController
{
    use UserDataTrait;

    /**
     * @Route("/", name="question_index", methods={"GET"})
     */
    public function index(Request $request, QuestionRepository $questionRepository): Response
    {
        return $this->render('content/question/index.html.twig', [
            'questions' => $questionRepository->findAll(),
            'user' => $this->getUserData($request)
        ]);
    }

    /**
     * @Route("/new", name="question_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'saved question: ' . $question->getId());
            return $this->redirectToRoute('question_index');
        }

        return $this->render('content/question/new.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
            'user' => $this->getUserData($request)
        ]);
    }

    /**
     * @Route("/{id}/edit", name="question_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Question $question): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'saved question: ' . $question->getId());
            return $this->redirectToRoute('question_index');
        }

        return $this->render('content/question/edit.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
            'user' => $this->getUserData($request),
        ]);
    }

    /**
     * @Route("/{id}", name="question_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Question $question): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('question_index');
    }
}
