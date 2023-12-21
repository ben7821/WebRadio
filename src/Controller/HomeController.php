<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Article;
use App\Entity\Emission;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $em): Response
    {
        $article = $em->getRepository(Article::class)->findAll();
        $emission = $em->getRepository(Emission::class)->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'article' => $article,
            'emissions' => $emission,
        ]);
    }

    #[Route('/plan_site', name: 'app_plan_site')]
    public function renderplan(): Response
    {
        return $this->render('home/plan_site.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function rendercontact(): Response
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/legal', name: 'app_legal')]
    public function renderlegal(): Response
    {
        return $this->render('home/legal.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
