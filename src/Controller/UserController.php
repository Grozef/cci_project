<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/user')]
class UserController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository,
                            PaginatorInterface $paginator, 
                            Request $request
                        ): Response {
            $users = $paginator->paginate(
            $userRepository->findAll(['user'=> $this ->getUser()]),
            $request->query->getInt('page', 1), 
            10 
        );
        return $this->render('pages/user/index.html.twig', [
            'users' => $users,
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

    // a parfaire -> differencier admin et current user
    #[Route('/user/{id}', name: 'app_user_show', methods: ['GET'])]
    #[IsGranted("ROLE_USER")]
    public function show(User $user): Response
    {

        if($this->isGranted('ROLE_ADMIN') || $user == $this->getUser() ){
            return $this->render('pages/user/show.html.twig', [
                'user' => $user,
            ]);
        } elseif(!$user){
            $this->addFlash('warning',' Ce n\'est pas votre profil !');
        }
        return $this->render('pages/home.html.twig');
    }


    #[IsGranted("ROLE_USER")]
    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        // $user = $this->getUser();
        if($this->isGranted('ROLE_ADMIN')){
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('app_user_show', [
                    'user' => $user,
                    'id' => $user->getId()
                    // getId() marqué comme erreur dans l'IDE ? -> fonctionne
                ]);
            }

            return $this->render('pages/user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
        } elseif($user == $this->getUser() ){
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('app_user_show', [
                    'user' => $user,
                    'id' => $user->getId()
                    // getId() marqué comme erreur dans l'IDE ? -> fonctionne
                ]);
            }

            return $this->render('pages/user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
        }elseif($this->getUser() !== $user){
            return $this->redirectToRoute('home.index');
        }
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
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
