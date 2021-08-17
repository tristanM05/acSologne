<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Machines;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MachineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('immatriculation', TextType::class)
            ->add('moteur', TextType::class)
            ->add('pMoteur', TextType::class,[
                'label' => 'Puissance moteur',
                'required' => false
            ])
            ->add('envergure', TextType::class)
            ->add('nbPlace', IntegerType::class,[
                'label' => 'Nombre de places',
                'required' => false
            ])
            ->add('vitesse', IntegerType::class,[
                'required' => false 
            ])
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
