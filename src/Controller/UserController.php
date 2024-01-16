<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('pages/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }


  /*  #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        $user = $this->getUser();
            if (!$user){
                return $this->render('pages/user/show.html.twig', [
                    'user' => $user,
                ]);
            }
    } */


    // adapter les vues pour que l'utilisateur connécté ne voie que sa fiche et pas la liste

    #[Route('/user/{id}', name: 'app_user_show', methods: ['GET'])]
    #[IsGranted("IS_AUTHENTICATED_FULLY")] // L'utilisateur doit être entièrement authentifié (connecté)
    public function show(User $user): Response
    {
        $loggedInUser = $this->getUser();

        // Vérifier si l'utilisateur connecté correspond à l'utilisateur dont l'ID est passé
        if (!$loggedInUser || $loggedInUser->getId() !== $user->getId()) {
            // throw $this->createAccessDeniedException('Accès non autorisé.');
            return $this->render('pages/home.html.twig');
            //message flash sur la page au lieu de l'erreur ?
        }

        return $this->render('pages/user/show.html.twig', [
            'user' => $user,
        ]);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre compte a été supprimé avec succés !'
            );
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
