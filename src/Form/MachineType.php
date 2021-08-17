<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Machines;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MachineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('immatriculation')
            ->add('moteur')
            ->add('pMoteur')
            ->add('envergure')
            ->add('nbPlace')
            ->add('vitesse')
            ->add('description', TextareaType::class)
            ->add('categories', EntityType::class,[
                'class' => Categories::class,
                'choice_label' => 'libelle'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Machines::class,
        ]);
    }
}
