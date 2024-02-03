<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\User;
use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GroupType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
        ->add('id_book', EntityType::class,[
            'label' => 'Livre',
            'class' => Book::class,
            'choice_label' => 'title',
            'required' => true,
            'label_attr' => [
                'class' => 'form-label mt-4 mr-4 darkblue'
            ],
        ])
        ->add('name_group', TextType::class, [
            'label' => 'Nom du groupe',
            'label_attr' => [
                'class' => 'form-label mt-4 mr-4 darkblue'
            ],
            'constraints' => [
                new Assert\Length([
                    'max' => 255
                ])
            ]
        ])
/*

*/

        ->add('creation_date', DateType::class,[
            'label' => 'Date',
            'label_attr' => [
                'class' => 'form-label mt-4 mr-4 darkblue'
            ],
        ])
        ->add('creation_date', DateType::class,[
            'label' => 'Date de la réunion',
            'label_attr' => [
                'class' => 'form-label mt-4 mr-4 darkblue'
            ],
        ])


        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'buttonbuttonmodif mt-4 mb-5'
            ],
            'label' => 'Enregistrer'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }
}
