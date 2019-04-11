<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class,$this->getConfiguration('Prénom','Votre prenom'))
            ->add('lastName',TextType::class,$this->getConfiguration('Nom','Votre nom'))
            ->add('email',EmailType::class,$this->getConfiguration('Email','Votre émail'))
            ->add('picture',UrlType::class,$this->getConfiguration('Image de profil',"donner l'url de votre avatar .."))
            ->add('hash',PasswordType::class,$this->getConfiguration('Mot de pass','donner un bon mot de pass'))
            ->add('confirmationPassword',PasswordType::class,$this->getConfiguration('Confirmation de Mot de pass','confirmer le mot de pass'))
            ->add('introduction',TextType::class,$this->getConfiguration('Introduction','Donner une bonne introduction'))
            ->add('descrition',TextareaType::class,$this->getConfiguration('Description','Donner une description'))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
