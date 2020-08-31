<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Bookingg;
use App\Form\BookingType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * permet de gérer une les réservations
     *@Route("/ads/{slug}/book", name="booking_create")
     *@IsGranted("ROLE_USER")
     * @param Ad $ad
     * @param Request $request
     * @return void
     */
    public function book(Ad $ad,Request $request,ObjectManager $manager)
    {   $booking = new Bookingg();
        $form = $this->createForm(BookingType::class,$booking);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();
            $booking->setBooker($user)
                    ->setAd($ad);
           $manager->persist($booking);
           $manager->flush();
           return $this->redirectToRoute('booking_succes',['id'=>$booking->getId()]);
        }
        return $this->render('booking/book.html.twig', [
            'ad' =>$ad,
            'form'=>$form->createView()
        ]);
    }
}
