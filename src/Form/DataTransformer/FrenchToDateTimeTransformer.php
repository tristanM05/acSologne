<?php
namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FrenchToDateTimeTransformer implements DataTransformerInterface {

    public function transform($date){

        if($date === null){
            return '';
    
        }
        return $date->format('d/m/Y');
    }
    public function reverseTransform($frenchDate){
        //frenchDate = dd/mm/yyyy

        if($frenchDate === null){
            //exeption
            throw new TransformationFailedException("vous devez fournir une date");
        }

        $date = \DateTime::createFRomFormat('d/m/Y', $frenchDate);

        if($date == false){
            //exeption
            throw new TransformationFailedException("le format de la date n'est pas le bon");
        }

        return $date;
    }
}