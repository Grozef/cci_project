<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '80'
                ],
                'label' => 'Nom / Prenom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Assert\Length(['min'=>2, 'max'=> 80])
                ]
                ])
            ->add('pseudonym', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '80'
                ],
                'required' => false,
                'label' => 'Pseudo',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Length(['min'=>2, 'max'=> 80])
                ]
                ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
                ]) 
            ->add('email')
            ->add('roles')
                           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

