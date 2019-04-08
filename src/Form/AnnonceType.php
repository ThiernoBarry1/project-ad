<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnonceType extends AbstractType
{  /**
 * permet la fonfiguration d'un champ
 *
 * @param String $label
 * @param String $placeHolder
 * @param Array $option
 * @return Array
 */
     private function getConfiguration($label , $placeHolder,$option=[])
     {
       return array_merge(['label'=>$label,'attr'=>[
               'placeholder'=>$placeHolder 
            ]],$option);
     }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,$this->getConfiguration('Titre','Tapez un titre'))
            ->add('slug',TextType::class,$this->getConfiguration('Chaine url','Donnez une url (automatique)',['required'=>false]))
            ->add('price',MoneyType::class,$this->getConfiguration('Prix','Donner un prix'))
            ->add('introduction',TextType::class,$this->getConfiguration('introduction','Donner une introduction'))
            ->add('content',TextareaType::class,$this->getConfiguration('Le contenu','Donner du contenu'))
            ->add('coverImage',UrlType::class,$this->getConfiguration('Url d\'image','Tapez une url'))
            ->add('rooms',IntegerType::class,$this->getConfiguration('chambre','le nombre de chambre'))
            ->add('images',CollectionType::class,
               [
                   'entry_type' => ImageType::class,
                   'allow_add'=>true,
                   'allow_delete'=>true
               ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
