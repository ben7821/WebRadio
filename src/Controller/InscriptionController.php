<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Form\InscriptionType;
use App\Repository\EmissionRepository;
use App\Repository\InscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Syfony\Controller\Participant;
use App\Controller\Collection;


///////////////////////////////////////////////
/// InscriptionController
/// Gestion des inscriptions aux émissions
///////////////////////////////////////////////
#[Route('/inscription')]
class InscriptionController extends AbstractController
{

    /// ------------------------------------------
    /// index
    /// Affiche la liste des inscriptions
    /// ------------------------------------------
    #[Route('/', name: 'app_inscription_index', methods: ['GET'])]
    public function index(InscriptionRepository $inscriptionRepository): Response
    {
        return $this->render('inscription/index.html.twig', [
            'inscriptions' => $inscriptionRepository->findAll(),
        ]);
    }

    /// ------------------------------------------
    /// new
    /// Création d'une nouvelle inscription
    /// ------------------------------------------
    #[Route('/new', name: 'app_inscription_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $inscription = new Inscription();

        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($inscription);
            $entityManager->flush();

            return $this->redirectToRoute('app_inscription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inscription/new.html.twig', [
            'inscription' => $inscription,
            'form' => $form,
        ]);
    }

    /// ------------------------------------------
    /// show
    /// Affiche une inscription
    /// ------------------------------------------
    #[Route('/{id}', name: 'app_inscription_show', methods: ['GET'])]
    public function show(Inscription $inscription, EntityManagerInterface $entityManager): Response
    {

        // Récupération des participants de l'inscription et de l'émission
        $participants = $inscription->getPARTICIPANT();
        $emission = $inscription->getEMS();

        return $this->render('inscription/show.html.twig', [
            'inscription' => $inscription,
            'emission' => $emission,
            'participants' => $participants
        ]);
    }

    /// ------------------------------------------
    /// edit
    /// Edition d'une inscription
    /// ------------------------------------------
    #[Route('/{id}/edit', name: 'app_inscription_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Inscription $inscription, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_inscription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inscription/edit.html.twig', [
            'inscription' => $inscription,
            'form' => $form,
        ]);
    }

    /// ------------------------------------------
    /// delete
    /// Suppression d'une inscription
    /// ------------------------------------------
    #[Route('/{id}', name: 'app_inscription_delete', methods: ['POST'])]
    public function delete(Request $request, Inscription $inscription, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inscription->getId(), $request->request->get('_token'))) {
            $entityManager->remove($inscription);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_creation', [], Response::HTTP_SEE_OTHER);
    }


}
