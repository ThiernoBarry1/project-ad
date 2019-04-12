<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AnnonceType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repos, SessionInterface $session)
    {
        $ads = $repos->findAll();  
        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }
    /**
     * permet de créer une annonce
     * 
     * @Route("/ads/new",name="new_ad")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $ad = new Ad();
       
        $form = $this->createForm(AnnonceType::class,$ad);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            // faire persister les images dans l'annonce
            foreach($ad->getImages() as $image)
            {
                $image->setAd($ad);
                $manager->persist($image);
            }
            $ad->setAutor($this->getUser());
            // on pouvais utiliser cette méthode .
            //$manager = $this->getDoctrine()->getManager();
            //Mais avec l'insection des dependances on vas plutot utiliser ObjectManager
            $manager->persist($ad);
            $manager->flush();
            $this->addFlash(
                'success',
                "l'annonce <strong>{$ad->getTitle()}</strong> a été enregistré avec succes ! "
            );
            // pour redirger vers une autre page ici ads_show
            return $this->redirectToRoute('ads_show',
               [
                 'slug' => $ad->getSlug()
               ]);
        }
         return $this->render('ad/new.html.twig',
        [
            'form'=>$form->createView()
        ]);
    }
    /**
     * permet d'afficher le formulaire d'edition d'une annonce 
     * @Route("ads/{slug}/edit",name="edit_ad")
     * @Security("is_granted('ROLE_USER') and user === ad.getAutor()",
     * message="cette annonce ne vous appartient pas vous ne pouvez pas la modifier !")
     * @return Response
     */
   public function edit(Ad $ad,Request $request,ObjectManager $manager)
   // parametre converter pour recuper l'annonce du slug correspondant
   {    $form = $this->createForm(AnnonceType::class,$ad);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // faire persister les images dans l'annonce
            foreach($ad->getImages() as $image)
            {
                $image->setAd($ad);
                $manager->persist($image);
            }
            // on pouvais utiliser cette méthode .
            //$manager = $this->getDoctrine()->getManager();
            //Mais avec l'insection des dependances on vas plutot utiliser ObjectManager
            $manager->persist($ad);
            $manager->flush();
            $this->addFlash(
                'success',
                "l'annonce <strong>{$ad->getTitle()}</strong> a été modifier avec succes ! "
            );
            // pour redirger vers une autre page ici ads_show
            return $this->redirectToRoute('ads_show',
               [
                 'slug' => $ad->getSlug()
               ]);
        }
       return $this->render('ad/edit.html.twig',
       ['form'=>$form->createView(), 
       'ad'=>$ad
       ]);
   }
    /**
     * permet d'afficher une seule annonce.
     * @Route("/ads/{slug}",name="ads_show")
     * @return Response 
     */
    public function show(Ad $ad)
    { // au lieu d'utiliser l'injection des dependance on utilise le parmetreConverter pour pour un annonce
      // beaucoup plus pratique pour avoir une annonce sans utiliser $ad =$repo->findOneBySlug($slug);
       return $this->render('ad/show.html.twig',
       [
           'ad'=>$ad,
       ]);
    }
    /**
     * permet de supprimer une annonce
     *@Route("ads/{slug}/delete",name="delete_ad")
     *@Security("is_granted('ROLE_USER') and user === ad.getAutor() ",message="Seule la personne qui a créee cette annonce peut la modifier")
     * @param Ad $ad
     * @param ObjectManager $manager
     * @return void
     */
    public function deleteAd(Ad $ad,ObjectManager $manager){
     $manager->remove($ad);
     $manager->flush();
     $this->addFlash("success","l'annonce {$ad->getTitle()} a éte supprimer avec success !");
     return $this->redirectToRoute("ads_index");
    
    }
    
}
