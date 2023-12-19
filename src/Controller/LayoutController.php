<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Emission;

class LayoutController extends AbstractController
{
    #[Route('/layout', name: 'app_layout')]
    public function index(EntityManagerInterface $em): Response
    {
        $emission = $em->getRepository(Emission::class)->findAll();

        return $this->render('layout/nav.html.twig', [
            'controller_name' => 'LayoutController',
            'emissions' => $emission,
        ]);
    }
}
