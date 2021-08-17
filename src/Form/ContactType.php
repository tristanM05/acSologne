<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
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
            ->add('phone', TextType::class,[
                'label' => 'Téléphone:'
            ])
            ->add('email', TextType::class,[
                'label' => 'Email:'
            ])
            ->add('message', TextareaType::class,[
                'label' => 'Message:',
                'attr' => [
                    'rows' => 10,
                    'cols' => 20
                    ]
            ])
            ->add('check', CheckboxType::class,[
                'label' => false,
                'required' => true
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
