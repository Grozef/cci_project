<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control darkblue',
                    'minlength' => '2',
                    'maxlength' => '255'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-4 darkblue'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Assert\Length(['min'=>2, 'max'=> 255])
                ]
                ])
            ->add('pseudonym', TextType::class, [
                'attr' => [
                    'class' => 'form-control darkblue',
                    'minlength' => '2',
                    'maxlength' => '255'
                ],
                'required' => false,
                'label' => 'Pseudo',
                'label_attr' => [
                    'class' => 'form-label mt-4 darkblue'
                ],
                'constraints' => [
                    new Length(['min'=>2, 'max'=> 255])
                ]
                ])
                ->add('roles', ChoiceType::class, [
                    'attr' => [
                        'class' => 'form-control darkblue',
                    ],
                        'choices' => ['ROLE_ADMIN' => 'ROLE_ADMIN', 'ROLE_USER' => 'ROLE_USER'],
                        'expanded' => true,
                        'multiple' => true,
                        'label_attr' => [
                            'class' => 'form-label mt-4 darkblue'
                        ],
                    ]
                )               
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '255'
                ],
                'label' => 'Adresse email',
                'label_attr' => [
                    'class' => 'form-label mt-4 darkblue'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min'=>2, 'max'=> 255])
                ]
            ])
                                    
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Mot de passe',
                    'label_attr' => [
                        'class' => 'form-label mt-4 darkblue'
                    ]
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Confirmation du mot de passe',
                    'label_attr' => [
                        'class' => 'form-label mt-4 darkblue'
                    ]
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas'
            ]) 
            
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'buttonbuttonmodif mt-4 mb-4'
                ],
                'label' => 'Enregistrer'
            ])            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

