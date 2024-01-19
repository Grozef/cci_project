<?php

namespace App\Controller;

use App\Entity\UserInfo;
use App\Entity\User;
use App\Form\UserInfoType;
use App\Repository\UserInfoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/info')]
class UserInfoController extends AbstractController
{
    #[Route('/', name: 'app_user_info_index', methods: ['GET'])]
    public function index(UserInfoRepository $userInfoRepository): Response
    {
        return $this->render('pages/user_info/index.html.twig', [
            'user_infos' => $userInfoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_info_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userInfo = new UserInfo();
        $form = $this->createForm(UserInfoType::class, $userInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($userInfo);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Vos nouvelles informations ont bien été sauvegardées !'
            );

            return $this->redirectToRoute('app_user_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/user_info/new.html.twig', [
            'user_info' => $userInfo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_info_show', methods: ['GET', 'POST'])]
    public function show(UserInfo $userInfo): Response
    {
        return $this->render('pages/user_info/show.html.twig', [
            'user_info' => $userInfo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_info_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserInfo $userInfo, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();
        //recuperer le user pour affficher les infos
        $form = $this->createForm(UserInfoType::class, $userInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

       /*     if ($this->isGranted('ROLE_ADMIN')) {
                return $this->render('pages/user/show.html.twig', [
                    'user' => $user,
                ]);
            } elseif ($user == $this->getUser()) {
                return $this->render('pages/user/show.html.twig', [
                    'user' => $user,
                ]);
            } elseif ($user !== $this->getUser()) {
                $this->addFlash('warning', ' Vous essayez d\'accéder à un profil qui n\'est pas le votre !');
            }
            return $this->render('pages/user/show.html.twig', [
                'user' => $currentUser,
            ]); */

            return $this->redirectToRoute('app_user_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/user_info/edit.html.twig', [
            'user_info' => $userInfo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_info_delete', methods: ['POST'])]
    public function delete(Request $request, UserInfo $userInfo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userInfo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($userInfo);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Vos informations ont bien été supprimées !'
            );
        }

        return $this->redirectToRoute('app_user_info_index', [], Response::HTTP_SEE_OTHER);
    }
}
