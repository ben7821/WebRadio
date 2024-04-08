<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Emission;

///////////////////////////////////////////////
/// LayoutController
/// Affiche le layout de l'application
///////////////////////////////////////////////
class LayoutController extends AbstractController
{

    /// ------------------------------------------
    /// index
    /// Affiche le layout de l'application avec les emissions et les audios
    /// ------------------------------------------
    #[Route('/layout', name: 'app_layout')]
    public function index(EntityManagerInterface $em): Response
    {
        $emission = $em->getRepository(Emission::class)->findAll();
        $data = array();

        // recupere tous les audios de toutes les emissions
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



