<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller{
   /** 
    * @Route("/home/{prenom}/age/{age}",name="hello")
   * @Route("/hello/",name="hello_base")
   * @Route("/home/{prenom}",name="hello_prenom")
   */
   public function hello($prenom="anonyme",$age=0 ){
      return $this->render('hello.html.twig',
              ['prenom'=>$prenom,'age'=>$age]
        );
   } 
/**
 * @Route("/",name="homePage")  
 */
public function home(){
   $tablau = ['leor'=>12,'thierno'=>7,"aliou"=>12];
   return $this->render('home.html.twig',
                  [
                     'title'=>'Salut à toutes et à tous',
                     'age' =>15,
                      'donnees'=>$tablau
                     ]);
}
}
?>