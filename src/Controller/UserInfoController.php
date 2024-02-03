<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\InfosType;
use App\Entity\UserInfo;
use App\Form\UserInfoType;
use Symfony\Component\Form\Form;
use App\Repository\UserRepository;
use App\Repository\UserInfoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

//this controller shows to an admin the list of the user's informations
#[Route('/user/info')]
class UserInfoController extends AbstractController
{
    #[IsGranted("ROLE_USER")]
    #[Route('/', name: 'app_user_info_index', methods: ['GET'])]
    public function index(
        UserInfoRepository $userInfoRepository,
        UserRepository $userRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $user_infos = $paginator->paginate(
            $userInfoRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        $users = $paginator->paginate(
            $userRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('pages/user_info/index.html.twig', [
                'user_infos' => $user_infos,
                'users' => $users,
            ]);
        } elseif ($this->isGranted('ROLE_USER')) {
            //Variable "user_info" a recupérer, render home ?
            $user = $this->getUser();
            $this->addFlash('warning', ' Vous n\'avez pas accès à la liste des utilisateurs inscrits, contactez un Admin !');
            return $this->render('pages/home.html.twig', [
                'user_infos' => $user_infos,
                'users' => $users,
                'user' => $user,
            ]);
        }
        return $this->render('pages/user_info/index.html.twig', [
            'user_infos' => $userInfoRepository->findAll(),
        ]);
    }

    // this controller allows an admin to create a new user and it's userInfos
    #[IsGranted("ROLE_ADMIN")]
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

    // this controller shows the complementary informations about an user
    #[IsGranted("ROLE_USER")]
    #[Route('/{id}', name: 'app_user_info_show', methods: ['GET', 'POST'])]
    public function show(UserInfo $userInfo, User $user): Response
    {
        $currentUser = $this->getUser();
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('pages/user_info/show.html.twig', [
                'user_info' => $userInfo,
                'user' => $user,
            ]);
        } elseif ($user == $this->getUser()) {
            return $this->render('pages/user_info/show.html.twig', [
                'user_info' => $userInfo,
                'user' => $currentUser,
            ]);
        } elseif ($user !== $this->getUser()) {;
            $this->addFlash('warning', ' Vous essayez d\'accéder à un profil qui n\'est pas le votre !');
        }
        return $this->render('pages/user_info/show.html.twig', [
            'user_info' => $userInfo,
            'user' => $currentUser,

        ]);
    }

    // this controller allows an user to edit it's own profile's informations
    // this controller allows an admin to modify anyone's profile informations
    #[IsGranted("ROLE_USER")]
    #[Route('/{id}/edit', name: 'app_user_info_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserInfo $userInfo, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();
        if ($this->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(UserInfoType::class, $userInfo);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $userInfo = $form->getData();
                $entityManager->persist($userInfo);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Les informations de ce compte ont été modifiées avec succés'
                );
                return $this->redirectToRoute('app_user_info_show', [
                    'user' => $user,
                    'id' => $user->getId()
                ]);
            }
        } elseif ($user == $this->getUser()) {
            $form = $this->createForm(UserInfoType::class, $userInfo);
            //cacher le champs role à un simple User
            $form->remove('roles');
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $userInfo = $form->getData();
                $entityManager->persist($userInfo);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Les informations de votre compte ont été modifiées avec succés'
                );
                return $this->redirectToRoute('app_user_info_show', [
                    'user' => $user,
                    'id' => $user->getId()
                ]);
            }
        } elseif ($this->getUser() !== $user) {
            $this->addFlash(
                'warning',
                'Vous essayez d\'accéder à des informations qui ne vous appartiennent pas !'
            );
            return $this->redirectToRoute('app_user_info_show', [
                'user' => $currentUser,
                'id' => $currentUser->getId()
            ]);
        }
        return $this->render('pages/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }


    //this controller allows an admin to delete an user's information
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/{id}', name: 'app_user_info_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserInfo $userInfo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userInfo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->remove($userInfo);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Le compte a bien été supprimé !'
            );
        }

        return $this->redirectToRoute('app_user_info_index');
    }
}
