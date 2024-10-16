<?php

namespace App\Form;

use App\Entity\UserInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class UserInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('direction', TextType::class, [
                'attr' => [
                    'class' => 'form-control darkblue',
                    'minlength' => '2',
                    'maxlength' => '255'
                ],
                'label' => 'Adresse',
                'label_attr' => [
                    'class' => 'form-label mt-4 darkblue'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('postalCode', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control darkblue',
                    'min' => 1000,
                    'max' => 99000
                ],
                'label' => 'Code Postal',
                'label_attr' => [
                    'class' => 'form-label mt-4 darkblue'
                ],
                'constraints' => [
                    new Assert\Positive(),
                ]
            ])
            ->add('town', TextType::class, [
                'attr' => [
                    'class' => 'form-control darkblue',
                    'minlength' => '2',
                    'maxlength' => '255'
                ],
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'form-label mt-4 darkblue'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('country', TextType::class, [
                'attr' => [
                    'class' => 'form-control darkblue',
                    'minlength' => '2',
                    'maxlength' => '255'
                ],
                'label' => 'Pays',
                'label_attr' => [
                    'class' => 'form-label mt-4 darkblue'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('tel', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control darkblue',
                    'min' => 1,
                    'max' => 799999999
                ],
                'required' => false,
                'label' => 'N° Téléphone',
                'label_attr' => [
                    'class' => 'form-label mt-4 darkblue'
                ],
                'constraints' => [
                    new Assert\Positive(),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'buttonbuttonmodif mt-4 mb-4'
                ],
                'label' => 'Modifier'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserInfo::class,
        ]);
    }
}
