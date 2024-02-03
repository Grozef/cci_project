<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\UserInfo;
use App\Form\AdditionnalType;
use App\Form\UserPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

//this controller show all users / only for Admins ?
#[Route('/user')]
class UserController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(
        UserRepository $userRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $users = $paginator->paginate(
            $userRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('pages/user/index.html.twig', [
                'users' => $users,
            ]);
        } elseif ($this->isGranted('ROLE_USER')) {
            $user = $this->getUser();
            $this->addFlash('warning', ' Vous n\'avez pas accès à la liste des utilisateurs inscrits, contactez un Admin !');
            return $this->render('pages/user/show.html.twig', [
                'user' => $user,
            ]);
        }
        return $this->render('pages/home.html.twig');
    }

    // This controller allow an admin to create a new user
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->add('userInfo', AdditionnalType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Retrieve User
            $user = $form->getData();
            // Retrieve the userInfo object from the form
            $userInfo = $form['userInfo']->getData();
            $user->setUserInfo($userInfo);
            // Hash the user's password
            // dd($user, $userInfo);
            $hashedPassword = $hasher->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $userInfo->setRelation($user);
            $entityManager->persist($userInfo);
            $entityManager->flush();
            $this->addFlash('success', ' Le compte a bien été créé !');
            return $this->render('pages/user/show.html.twig', [
                'user' => $user,
            ]);
        }
        return $this->render('pages/user/new.html.twig', [
            'form' => $form,
        ]);
    }

    // this controller show the user's information
    #[Route('/user/{id}', name: 'app_user_show', methods: ['GET'])]
    #[IsGranted("ROLE_USER")]
    public function show(User $user): Response
    {
        $currentUser = $this->getUser();
        if ($this->isGranted('ROLE_ADMIN')) {
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
        ]);
    }

    // this controller allows an user to edit it's own profile's informations
    // this controller allows an admin to modify anyone's profile informations
    #[IsGranted("ROLE_USER")]
    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
    {
        $currentUser = $this->getUser();
        if ($this->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                if ($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())) {
                    $user = $form->getData();
                    $entityManager->persist($user);
                    $entityManager->flush();

                    $this->addFlash(
                        'success',
                        'Les informations de votre compte ont été modifiées avec succés'
                    );
                    return $this->redirectToRoute('app_user_show', [
                        'user' => $user,
                        'id' => $user->getId()
                    ]);
                } else {
                    $this->addFlash(
                        'warning',
                        'Le mot de passe renseigné est incorrect'
                    );
                    return $this->redirectToRoute('app_user_edit', [
                        'user' => $user,
                        'id' => $user->getId()
                    ]);
                }
            }
        } elseif ($user == $this->getUser()) {
            $form = $this->createForm(UserType::class, $user);
            //cacher le champs role à un simple User
            $form->remove('roles');
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                if ($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())) {
                    $user = $form->getData();
                    $entityManager->persist($user);
                    $entityManager->flush();

                    $this->addFlash(
                        'success',
                        'Les informations de votre compte ont été modifiées avec succés'
                    );
                    return $this->redirectToRoute('app_user_show', [
                        'user' => $user,
                        'id' => $user->getId()
                    ]);
                } else {
                    $this->addFlash(
                        'warning',
                        'Le mot de passe renseigné est incorrect'
                    );
                    return $this->redirectToRoute('app_user_edit', [
                        'user' => $user,
                        'id' => $user->getId()
                    ]);
                }
            }
        } elseif ($this->getUser() !== $user) {
            $this->addFlash(
                'warning',
                'Vous essayez d\'accéder à des informations qui ne vous appartiennent pas !'
            );
            return $this->redirectToRoute('app_user_show', [
                'user' => $currentUser,
                'id' => $currentUser->getId()
            ]);
        }
        return $this->render('pages/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // This controller allows an admin to delete an user's profile
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserInfo $userInfo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->remove($userInfo);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Ce compte a été supprimé avec succés !'
            );
        }
        return $this->redirectToRoute('app_user_info_index');
    }

    //this controller allows an user to modify it's own password
    #[IsGranted('ROLE_USER')]
    #[Route('/edit_password/{id}', 'user_edit_password', methods: ['GET', 'POST'])]
    public function editPassword(
        User $user,
        Request $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $manager
    ): Response {

        $currentUser = $this->getUser();
        $form = $this->createForm(UserPasswordType::class);
        $form->handleRequest($request);

        if ($this->getUser() !== $user) {
            $this->addFlash(
                'warning',
                'Vous essayez d\'accéder à un mot de passe dont vous n\'êtes pas proprietaire !'
            );
            return $this->redirectToRoute('app_user_show', [
                'user' => $currentUser,
                'id' => $currentUser->getId()
            ]);
        }
        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()['plainPassword'])) {

                // Si bug symfony, si le preUpdate ne flush pas la donnée
                $user->setPassword(
                    $hasher->hashPassword(
                        $user,
                        $form->getData()['newPassword']
                    )
                );
                // verifier avec l'eventListener
                /*
                $user->setPlainPassword(
                    $form->getData()['newPassword']
                );
                */
                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Votre mot de passe a été modifié avec succés'
                );

                return $this->render('pages/user/edit_password.html.twig', [
                    'form' => $form->createView()
                ]);
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect'
                );
                return $this->render('pages/user/edit_password.html.twig', [
                    'form' => $form->createView()
                ]);
            }
        } else {
            if (!$form->get('recaptcha')->getData() && $form->isSubmitted()) {
                $this->addFlash('warning', 'Le champ reCAPTCHA doit être coché.');
            }
        }

        return $this->render('pages/user/edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
