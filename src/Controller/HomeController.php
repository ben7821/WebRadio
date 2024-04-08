<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Article;
use App\Entity\Emission;

///////////////////////////////////////////////
/// Home Controller
/// Gestion de la page d'accueil du site
///////////////////////////////////////////////
class HomeController extends AbstractController
{

    /// ------------------------------------------
    /// index
    /// Affichage de la page d'accueil
    /// ------------------------------------------
    #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $em): Response
    {
        
        $emission = $em->getRepository(Emission::class)->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            
            'emissions' => $emission,
        ]);
    }

    /// ------------------------------------------
    /// renderplan
    /// Affichage de la page plan du site
    /// ------------------------------------------
    #[Route('/plan_site', name: 'app_plan_site')]
    public function renderplan(): Response
    {
        return $this->render('home/plan_site.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /// ------------------------------------------
    /// rendercontact
    /// Affichage de la page contact du site
    /// ------------------------------------------
    #[Route('/contact', name: 'app_contact')]
    public function rendercontact(): Response
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /// ------------------------------------------
    /// renderlegal
    /// Affichage de la page legal du site
    /// ------------------------------------------
    #[Route('/legal', name: 'app_legal')]
    public function renderlegal(): Response
    {
        return $this->render('home/legal.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
