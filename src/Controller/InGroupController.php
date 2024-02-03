<?php

namespace App\Controller;

use App\Entity\InGroup;
use App\Form\InGroupType;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InGroupController extends AbstractController
{
    #[Route('/in/group', name: 'app_in_group')]
    public function index(): Response
    {
        return $this->render('pages/in_group/index.html.twig', [
            'controller_name' => 'InGroupController',
        ]);
    }

    #[Route('/in/group/new', name: 'app_in_group_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, GroupRepository $groupRepository): Response
    {
        $inGroup = new inGroup();
        $form = $this->createForm(InGroupType::class, $inGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($inGroup);
            $entityManager->flush();

            return $this->redirectToRoute('app_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/group/new.html.twig', [
            'groups' => $groupRepository->findAll(),
            'inGroup' => $inGroup,
            'form' => $form,
        ]);
    }
}
