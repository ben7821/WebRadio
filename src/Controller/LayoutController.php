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
        $data = array();

        foreach ($emission as $emi) {
            $data[] = $emi->getAudio()->toArray();
        }

        return $this->render('base.html.twig', [
            'controller_name' => 'LayoutController',
            'header_emissions' => $emission,
            'lecteurdata' => $data,
        ]);
    }
}



