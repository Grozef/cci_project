<?php

namespace App\Form;

use Assert\checked;
use App\Entity\User;
use App\Entity\UserInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RegistrationType extends AbstractType
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
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
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
                'label' => 'Pseudo (Facultatif)',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min'=>2, 'max'=> 80])
                ]
                ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control mb-4',
                    'minlength' => '2',
                    'maxlength' => '180'
                ],
                'label' => 'Adresse email',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min'=>2, 'max'=> 180])
                ]
            ])

            ->add('userInfo', CollectionType::class, [
                'entry_type' => AdditionnalType::class,
            ])

            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Mot de passe',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ]
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control mb-4'
                    ],
                    'label' => 'Confirmation du mot de passe',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ]
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas'
            ])

            ->add("recaptcha", ReCaptchaType::class, [
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'buttonbutton mt-4 mb-4'
                ],
                'label' => 'Enregistrer'

            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
