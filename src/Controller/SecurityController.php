<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserInfo;
use App\Form\AdditionnalType;
use App\Form\RegistrationType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class SecurityController extends AbstractController
{
    //this controller allows us to login
    #[Route('/connexion', name: 'security.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $lastUsername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('pages/security/login.html.twig', [

            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    //this controller allows us to logout
    #[Route('/deconnexion', name: 'security.logout')]
    public function logout()
    {
        //Nothing to do here, symfony does all the work
    }

    //this controller allows us to register ourselves
    #[Route('/inscription', 'security.registration', methods: ['GET', 'POST'])]
    public function registration(
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $hasher,
    ): Response {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        $form = $this->createForm(RegistrationType::class, $user);
        $form->add('userInfo', AdditionnalType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            // Retrieve the userInfo object from the form
            $userInfo = $form['userInfo']->getData();
            $user->setUserInfo($userInfo);

            // Hash the user's password
            $hashedPassword = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $manager->persist($user);

            $userInfo->setRelation($user);
            $manager->persist($userInfo);
            // dd($userInfo);  
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre compte a bien été créé !'
            );

            return $this->redirectToRoute('security.login');
        } else {
            if (!$form->get('recaptcha')->getData() && $form->isSubmitted()) {
                $this->addFlash('danger', 'Le champ reCAPTCHA doit être coché.');
                return $this->render('pages/security/registration.html.twig', [
                    'form' => $form->createView()
                ]);
            }
        }
        return $this->render('pages/security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
