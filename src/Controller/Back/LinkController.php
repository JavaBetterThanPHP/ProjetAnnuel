<?php

namespace App\Controller\Back;

use App\Entity\Link;
use App\Form\LinkType;
use App\Repository\LinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/link")
 */
class LinkController extends AbstractController
{
    /**
     * @Route("/", name="link_index", methods={"GET"})
     */
    public function index(LinkRepository $linkRepository): Response
    {
        return $this->render('Back/link/index.html.twig', ['links' => $linkRepository->findAll()]);
    }

    /**
     * @Route("/new", name="link_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $link = new Link();
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($link);
            $entityManager->flush();

            return $this->redirectToRoute('link_index');
        }

        return $this->render('Back/link/new.html.twig', [
            'link' => $link,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="link_show", methods={"GET"})
     */
    public function show(Link $link): Response
    {
        return $this->render('Back/link/show.html.twig', ['link' => $link]);
    }

    /**
     * @Route("/{id}/edit", name="link_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Link $link): Response
    {
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('link_index', ['id' => $link->getId()]);
        }

        return $this->render('Back/link/edit.html.twig', [
            'link' => $link,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="link_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Link $link): Response
    {
        if ($this->isCsrfTokenValid('delete' . $link->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($link);
            $entityManager->flush();
        }

        return $this->redirectToRoute('link_index');
    }
}