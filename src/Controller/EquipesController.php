<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Equipe;

class EquipesController extends AbstractController
{
    #[Route('/equipes', name: 'app_equipes')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('equipes/index.html.twig', [
            'controller_name' => 'EquipesController',
        ]);
    }

    #[Route('/membres', name: 'app_membres')]
    public function getAllMembres(EntityManagerInterface $entityManager) : Response{
        $membres = $entityManager->getRepository(Equipe::class)->findAll();
        return $this->render('equipes/membres.html.twig', [
            'membres' => $membres,
        ]);
    }

    #[Route('/lycee', name: 'app_lycee')]
    public function renderLycee(EntityManagerInterface $entityManager){
        return $this->render('equipes/lycee.html.twig', [
            'controller_name' => 'EquipesController',
        ]);
    }





}
