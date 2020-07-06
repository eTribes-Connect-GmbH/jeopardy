<?php

namespace App\Controller;

use App\Entity\Buzzword;
use App\Form\BuzzwordType;
use App\Repository\BuzzwordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/buzzword")
 */
class BuzzwordController extends AbstractController
{
    /**
     * @Route("/", name="buzzword_index", methods={"GET"})
     */
    public function index(BuzzwordRepository $buzzwordRepository): Response
    {
        return $this->render('buzzword/index.html.twig', [
            'buzzwords' => $buzzwordRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="buzzword_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $buzzword = new Buzzword();
        $form = $this->createForm(BuzzwordType::class, $buzzword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($buzzword);
            $entityManager->flush();

            return $this->redirectToRoute('buzzword_index');
        }

        return $this->render('buzzword/new.html.twig', [
            'buzzword' => $buzzword,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="buzzword_show", methods={"GET"})
     */
    public function show(Buzzword $buzzword): Response
    {
        return $this->render('buzzword/show.html.twig', [
            'buzzword' => $buzzword,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="buzzword_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Buzzword $buzzword): Response
    {
        $form = $this->createForm(BuzzwordType::class, $buzzword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('buzzword_index');
        }

        return $this->render('buzzword/edit.html.twig', [
            'buzzword' => $buzzword,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="buzzword_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Buzzword $buzzword): Response
    {
        if ($this->isCsrfTokenValid('delete'.$buzzword->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($buzzword);
            $entityManager->flush();
        }

        return $this->redirectToRoute('buzzword_index');
    }
}
