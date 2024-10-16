<?php

namespace App\Controller;

use App\Entity\Group;
use App\Form\GroupType;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// this controller displays all the groups
#[Route('/group')]
class GroupController extends AbstractController
{
    #[Route('/', name: 'app_group_index', methods: ['GET'])]
    public function index(GroupRepository $groupRepository): Response
    {
        // $groups = $groupRepository->findAll();
        // dd($groups);
        return $this->render('pages/group/index.html.twig', [
            'groups' => $groupRepository->findAll(),
            
        ]);
    }

    // this controller allows an admin to create a new group
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_group_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($group);
            $entityManager->flush();

            return $this->redirectToRoute('app_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/group/new.html.twig', [
            'group' => $group,
            'form' => $form,          
        ]);
    }

    // this controller shows the specifics of a group
    #[Route('/{id}', name: 'app_group_show', methods: ['GET'])]
    public function show(Group $group): Response
    {

        return $this->render('pages/group/show.html.twig', [
            'group' => $group,
        ]);
    }

    // this controller allows an admin to modify a group
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_group_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Group $group, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre groupe a été modifié avec succès !'
            );

            return $this->redirectToRoute('app_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/group/edit.html.twig', [
            'group' => $group,
            'form' => $form,
        ]);
    }

    // this controller allow an admin to delete a group
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_group_delete', methods: ['POST'])]
    public function delete(Request $request, Group $group, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $group->getId(), $request->request->get('_token'))) {
            $entityManager->remove($group);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre groupe a été supprimé avec succès !'
            );
        }

        return $this->redirectToRoute('app_group_index', [], Response::HTTP_SEE_OTHER);
    }
}
