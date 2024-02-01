<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InGroupController extends AbstractController
{
    #[Route('/in/group', name: 'app_in_group')]
    public function index(): Response
    {
        return $this->render('pages/in_group/index.html.twig', [
            'controller_name' => 'InGroupController',
        ]);
    }
}
