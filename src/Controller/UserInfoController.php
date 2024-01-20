<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\UserInfo;
use App\Form\UserInfoType;
use App\Repository\UserRepository;
use App\Repository\UserInfoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/user/info')]
class UserInfoController extends AbstractController
{
    #[IsGranted("ROLE_USER")]
    #[Route('/', name: 'app_user_info_index', methods: ['GET'])]
    public function index(UserInfoRepository $userInfoRepository,
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

        if($this->isGranted('ROLE_ADMIN')){
            return $this->render('pages/user_info/index.html.twig', [
                'user_infos' => $user_infos,
                'users' => $users,
            ]);
        }elseif($this->isGranted('ROLE_USER')){
            $user = $this->getUser();
                $this->addFlash('warning', ' Vous n\'avez pas accès à la liste des utilisateurs inscrits, contactez un Admin !');
                return $this->render('pages/user_info/show.html.twig', [
                    'user' => $user,
                ]);        
        }
        return $this->render('pages/user_info/index.html.twig', [
            'user_infos' => $userInfoRepository->findAll(),
        ]);
    }

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

    #[IsGranted("ROLE_USER")]
    #[Route('/{id}', name: 'app_user_info_show', methods: ['GET', 'POST'])]
    public function show(UserInfo $userInfo, User $user): Response
    {   
        $user = $this->getUser();
        $targetUser = $userInfo ->getId();

        // dd($targetUser, $user->getId());
        // $infoUser = $this->getInfoUser();

        /*
                $user = $this->getUser();
        return $this->render('pages/user_info/show.html.twig', [
            'user_info' => $userInfo,
            'user'=> $user,
        ]);
        */

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('pages/user_info/show.html.twig', [
                'user_info' => $userInfo,
                'user' => $user,
            ]);
        } elseif ($targetUser == $user->getId()) {
            return $this->render('pages/user_info/show.html.twig', [
                'user_info' => $userInfo,
                'user' => $user,
            ]);
        } elseif ($targetUser !== $user->getId()) {
            $this->addFlash('warning', ' Vous essayez d\'accéder à un profil qui n\'est pas le votre !');
        }
        
        return $this->render('pages/user_info/show.html.twig', [
            'user_info' => $userInfo,
            'user' => $user,

        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_info_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserInfo $userInfo, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();
        //recuperer le user pour affficher les infos

        $form = $this->createForm(UserInfoType::class, $userInfo);
        $formUser = $this->createForm(UserType::class, $user );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $formUser->isSubmitted() && $formUser->isValid()) {
            $entityManager->flush();

            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->render('pages/user/show.html.twig', [
                    'user' => $user,
                    'user_info' => $userInfo,
                ]);
            } elseif ($user == $this->getUser()) {
                return $this->render('pages/user/show.html.twig', [
                    'user' => $user,
                    'user_info' => $userInfo,
                ]);
            } elseif ($user !== $this->getUser()) {
                $this->addFlash('warning', ' Vous essayez d\'accéder à un profil qui n\'est pas le votre !');
            }
            return $this->render('pages/user/show.html.twig', [
                'user' => $user,
                'user_info' => $userInfo,
            ]); 

            return $this->redirectToRoute('app_user_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/user_info/edit.html.twig', [
            'user_info' => $userInfo,
            'user' => $user,
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
