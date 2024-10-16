<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', 'home.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/home.html.twig');
    }
    #[Route('/confidentialite', 'legals_confidentialite', methods: ['GET'])]
    public function confidentialite(): Response
    {
        return $this->render('pages/legals/confidentialite.html.twig');
    }

    #[Route('/legals/mentions', 'legals_mentions', methods: ['GET'])]
    public function mentions(): Response
    {
        return $this->render('pages/legals/mentions.html.twig');
    }

    #[Route('/legals/erreur', 'legals_erreur', methods: ['GET'])]
    public function erreur(): Response
    {
        return $this->render('pages/legals/erreur.html.twig');
    }
}
