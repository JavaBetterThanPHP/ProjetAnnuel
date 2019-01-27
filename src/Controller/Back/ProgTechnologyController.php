<?php

namespace App\Controller\Back;

use App\Entity\ProgTechnology;
use App\Form\ProgTechnologyType;
use App\Repository\ProgTechnologyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/prog/technology", name="back_prog_technology_")
 */
class ProgTechnologyController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ProgTechnologyRepository $progTechnologyRepository): Response
    {
        return $this->render('Back/prog_technology/index.html.twig', ['prog_technologies' => $progTechnologyRepository->findAll()]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $progTechnology = new ProgTechnology();
        $form = $this->createForm(ProgTechnologyType::class, $progTechnology);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($progTechnology);
            $entityManager->flush();

            return $this->redirectToRoute('back_prog_technology_index');
        }

        return $this->render('Back/prog_technology/new.html.twig', [
            'prog_technology' => $progTechnology,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(ProgTechnology $progTechnology): Response
    {
        return $this->render('Back/prog_technology/show.html.twig', ['prog_technology' => $progTechnology]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProgTechnology $progTechnology): Response
    {
        $form = $this->createForm(ProgTechnologyType::class, $progTechnology);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_prog_technology_index', ['id' => $progTechnology->getId()]);
        }

        return $this->render('Back/prog_technology/edit.html.twig', [
            'prog_technology' => $progTechnology,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProgTechnology $progTechnology): Response
    {
        if ($this->isCsrfTokenValid('delete' . $progTechnology->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($progTechnology);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_prog_technology_index');
    }
}
