<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType{
    /**
    * permet la fonfiguration d'un champ
    *
    * @param String $label
    * @param String $placeHolder
    * @param Array $option
    * @return Array
    */
    protected function getConfiguration($label , $placeHolder,$option=[])
    {
         return array_merge(['label'=>$label,'attr'=>[
                  'placeholder'=>$placeHolder 
                            ]
                        ],$option);
    }
}