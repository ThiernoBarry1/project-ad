<?php

namespace App\Form;

use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword',PasswordType::class,$this->getConfiguration("l'ancien mot de passe",'donner l\ancien'))
            ->add('newPassWord',PasswordType::class,$this->getConfiguration("le nouveau mot de passe",'donner le nouveau mot de passe ...'))
            ->add('confimPassWord',PasswordType::class,$this->getConfiguration("confirmer le mot de passe",' donner le nouveau mot de passe ...'))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
