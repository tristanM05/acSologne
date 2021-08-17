<?php

namespace App\Form;

use App\Entity\Vol;
use App\Form\DateVolType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserVolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre:'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Message:',
                'attr' => [
                    'rows' => 10
                ]
            ])
            ->add('dates', CollectionType::class, [
                'entry_type' => DateVolType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,

            ]);
        // ->add('images', CollectionType::class, ['entry_type' => ImageType::class, 'allow_add' => true, 'allow_delete' => true])
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vol::class,
        ]);
    }
}
