<?php

namespace App\Form;

use App\Entity\Date;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;

class DateVolType extends AbstractType
{
    private $transformer;

    public function __construct(FrenchToDateTimeTransformer $transformer){
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbPlace', IntegerType::class,[
                'label' => 'Nombre de places:',
                'required' => false
            ])
            ->add('date', TextType::class,[
                'label' => 'Date du vol:',
                'required' => false
            ])
        ;

        $builder->get('date')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Date::class,
        ]);
    }
}
