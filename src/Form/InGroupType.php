<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Group;
use App\Entity\InGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id_group', EntityType::class,[
                'label' => 'name',
                'class' => Group::class,
                'choice_label' => 'name_group',
                'required' => true,
                'label_attr' => [
                    'class' => 'form-label mt-4 mr-4 darkblue'
                ],
            ])
            
            ->add('id_user', EntityType::class,[
                'label' => 'name',
                'class' => User::class,
                'choice_label' => 'name',
                'required' => true,
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
            'data_class' => InGroup::class,
        ]);
    }
}
