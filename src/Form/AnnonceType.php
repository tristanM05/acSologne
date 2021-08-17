<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\AnnonceCat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Titre:'
            ])
            ->add('annonceCat', EntityType::class,[
                'class' => AnnonceCat::class,
                'choice_label' => 'libelle',
                'label' => 'Choisissez une catégorie:'
            ])
            ->add('content', TextareaType::class,[
                'label' => 'Description:',
                'attr' =>[
                    'rows' => 10
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
