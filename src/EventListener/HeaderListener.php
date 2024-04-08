<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Emission;

///////////////////////////////////////////////
/// HeaderListener
/// Récupère les émissions pour les afficher dans le header
///////////////////////////////////////////////
class HeaderListener
{

    /// l'entity manager
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /// ------------------------------------------
    /// onKernelController
    /// Récupère les émissions pour les afficher dans le header
    /// ------------------------------------------
    public function onKernelController(ControllerEvent $e) {
        $cont = $e->getController();

        if (is_array($cont)) {
            $cont = $cont[0];
        }

        if ($cont instanceof \Symfony\Bundle\FrameworkBundle\Controller\AbstractController) {
            $emission = $this->em->getRepository(Emission::class)->findAll();
            $e->getRequest()->attributes->set('header_emissions', $emission);
        }
    }
}
