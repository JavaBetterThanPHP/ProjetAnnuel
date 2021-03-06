<?php

namespace App\Controller\Back;

use App\Entity\JobType;
use App\Form\JobTypeType;
use App\Repository\JobTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/jobType", name="back_job_type_")
 */
class JobTypeController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(JobTypeRepository $jobTypeRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('Back/job_type/index.html.twig', ['job_types' => $jobTypeRepository->findAll(),'user' => $user]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $jobType = new JobType();
        $form = $this->createForm(JobTypeType::class, $jobType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($jobType);
            $entityManager->flush();

            return $this->redirectToRoute('back_job_type_index');
        }

        return $this->render('Back/job_type/new.html.twig', [
            'job_type' => $jobType,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(JobType $jobType): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('Back/job_type/show.html.twig', ['job_type' => $jobType,'user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, JobType $jobType): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(JobTypeType::class, $jobType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_job_type_index', ['id' => $jobType->getId()]);
        }

        return $this->render('Back/job_type/edit.html.twig', [
            'job_type' => $jobType,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, JobType $jobType): Response
    {
        if ($this->isCsrfTokenValid('delete' . $jobType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($jobType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_job_type_index');
    }
}
