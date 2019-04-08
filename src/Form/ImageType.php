<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url_image',UrlType::class,
            [
              'attr'=> 
              ['placeholder'=>'url de l\'image', 'width'=>'20px']
            ])
            ->add('caption', TextType::class,
              [
                'attr'=> 
                ['placeholder'=>'la description de l\'image', 'width'=>'10px']
              ])
            // il faut virer l'ad car le formulaire est déjà dans une annonce
            //->add('ad')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
