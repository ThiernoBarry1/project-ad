<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /** permet la gesition de la connexion
     * @Route("/login", name="account_login")
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
         dump($error);
        return $this->render('account/login.html.twig',
                            ['hasError'=> $error != null,'error'=>$error]
                        );
    }
    /**
     * permet de se deconnecter
     *@Route("/logout",name="account_logout")
     * @return void
     */
    public function logout()
    {
        // rien ...
    }
    /**
     * permet à l'utilisateur de s'inscrire 
     *@Route("/register",name="account_register")
     * @return Response
     */
    public function registration(Request $request,ObjectManager $manager,UserPasswordEncoderInterface $encode){
        $user = new User();
        $form = $this->createForm(RegistrationType::class,$user);
        // pour que symfony puisse gérer la requete
        $form->handleRequest($request); 
        if( $form->isSubmitted() && $form->isValid()){
            $password = $encode->encodePassword($user,$user->getHash());
            $user->setHash($password);
            $manager->persist($user);
            $manager->flush();
            //pour mettre un flass d'information
            $this->addflash('success','votre compte a bien été créer');
            return $this->redirectToRoute('account_login');
        }
       return $this->render('account/registration.html.twig',['form'=>$form->createView()]);
    }
    /**
     * permet de modifier un profil utilisateur
     *@Route("/account/update",name="account_update")
     * @return Response
     */
    public function updateProfil(Request $request,ObjectManager $manager){
        // pour obtenir l'utilisateur connecté
        $user = $this->getUser();
        $form =$this->createForm(AccountType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ) {
            $manager->persist($user);
            $manager->flush();
            $this->addflash('success','la modification de '.$user->getLastName().' a été enregistré avec success !');
            return $this->redirectToRoute('account_update');
        }
       return  $this->render('account/updateProfil.html.twig',
                   ['form'=>$form->createView()]);
    }
    /**
     * modification du mot de passe
     *@Route("/account/update-password",name="account-update-password")
     * @return Response
     */
    public function updatePassword(Request $request,ObjectManager $manager,UserPasswordEncoderInterface $encode){
        $passwordUpdate = new PasswordUpdate();
        $form = $this->createForm(PasswordUpdateType::class,$passwordUpdate);
        $form->handleRequest($request);
        $user = $this->getUser();
        if( $form->isSubmitted() && $form->isValid() ){
          if(!password_verify($passwordUpdate->getOldPassword(),$user->getHash()))
          {
             $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapez est incorecte"));
          }else{
            $newPassWord = $passwordUpdate->getNewPassword();
            $password = $encode->encodePassword($user,$newPassWord); 
            $user->setHash($password);
            $manager->persist($user);
            $manager->flush();
            $this->addflash('success','le mot de passe a été supprimer avec success');
            return $this->redirectToRoute('homePage');
          }
        }
       return $this->render('account/updatePassword.html.twig',['form'=>$form->createView()]);
    }
    /**
     * le compte de l'utilisateur connecté
     *@Route("/account",name="account_index")
     * @return Response
     */
    public function  myAccount(){
       return $this->render('user/index.html.twig',['user'=>$this->getUser()]);
    }
}
