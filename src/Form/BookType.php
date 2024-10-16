<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
// utilisation et appel de validator pour les contraintes BDD
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control darkblue',
                    'minlength' => '2',
                    'maxlength' => '255'
                ],
                'label' => 'Titre',
                'label_attr' => [
                    'class' => 'form-label mt-4 darkblue'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Author', TextType::class, [
                'attr' => [
                    'class' => 'form-control darkblue',
                    'minlength' => '2',
                    'maxlength' => '255'
                ],
                'label' => 'Auteur',
                'label_attr' => [
                    'class' => 'form-label mt-4 darkblue'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control darkblue',
                    'min' => 1,
                    'max' => 5
                ],
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label mt-4 darkblue'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('price', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control darkblue',
                ],
                'label' => 'Prix en ',
                'label_attr' => [
                    'class' => 'form-label mt-4 darkblue'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(255)
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
            'data_class' => Book::class,
        ]);
    }
}
