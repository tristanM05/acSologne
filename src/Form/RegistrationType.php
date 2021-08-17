<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class,[
                'label' => 'Prénom:'
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Nom:'
            ])
            ->add('email', TextType::class,[
                'label' => 'E-mail:'
            ])
            ->add('phone', TextType::class,[
                'label' => 'Téléphone:'
            ])
            ->add('hash', PasswordType::class,[
                'label' => 'Mot de passe'
            ])
            ->add('passwordConfirm', PasswordType::class,[
                'label' => 'Confirmation du mot de passe:'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
