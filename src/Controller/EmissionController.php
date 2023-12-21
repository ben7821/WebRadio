<?php

namespace App\Controller;

use App\Entity\Emission;
use App\Form\EmissionType;
use App\Repository\EmissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/emission')]
class EmissionController extends AbstractController
{
    #[Route('/', name: 'app_emission_index', methods: ['GET'])]
    public function index(EmissionRepository $emissionRepository): Response
    {
        return $this->render('emission/index.html.twig', [
            'emissions' => $emissionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_emission_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $emission = new Emission();
        $form = $this->createForm(EmissionType::class, $emission);
        $form->handleRequest($request);
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($emission);
            $entityManager->flush();

            return $this->redirectToRoute('app_emission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('emission/new.html.twig', [
            'emission' => $emission,
            'form' => $form,
        ]);
    }

    #[Route('/{NOM}', name: 'app_emission_show', methods: ['GET'])]
    public function show(Emission $emission): Response
    {
        return $this->render('emission/show.html.twig', [
            'emission' => $emission,
            'audios' => $emission->getAudio(),
        ]);
    }

    #[Route('/{ID}/edit', name: 'app_emission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Emission $emission, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EmissionType::class, $emission);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_emission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('emission/edit.html.twig', [
            'emission' => $emission,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{ID}', name: 'app_emission_delete', methods: ['POST'])]
    public function delete(Request $request, Emission $emission, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emission->getID(), $request->request->get('_token'))) {
            $entityManager->remove($emission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_emission_index', [], Response::HTTP_SEE_OTHER);
    }

}
