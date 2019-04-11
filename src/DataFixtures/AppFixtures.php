<?php
namespace App\DataFixtures;
use App\Entity\Ad;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{   private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder) {
      $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {   $faker = Factory::create("fr-FR");
        $users =[];
        $genres = ['male','female'];
        // ici nous créons des utilisateurs
        for($i =0;$i<= 10;$i++)
        {
           $user = new User();
           $genre = $faker->randomElement($genres);
           $picture = 'https://randomuser.me/api/portraits/';
           $pictureId = $faker->numberBetween(1,99).'.jpg';
           if($genre === 'male') $picture .=  "men/".$pictureId;
           else $picture .= "women/".$pictureId;
           $pass = $this->encoder->encodePassword($user,'password');
           $user->setFirstName($faker->firstname($genre))
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setDescrition('<p>'.join('<p></p>',$faker->paragraphs(5)).'</p>')
                ->setHash($pass)
                ->setPicture($picture);
            $manager->persist($user);
            $users[] = $user;
        }
        
        // ici nous créeons des annonces
        for($i = 0;$i<= 30;$i++){
            $ad = new Ad();
            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(200,350);
            $introduction = $faker->paragraph(2);
            $content = '<p>'.join('<p></p>',$faker->paragraphs(5)).'</p>';
            $user = $users[mt_rand(0,count($users)-1)];
            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setPrice(mt_rand(100,500))
                ->setRooms(mt_rand(2,6))
                ->setContent($content)
                ->setAutor($user);
            $manager->persist($ad);
        
        for($j= 0;$j<mt_rand(2,5);$j++)
        {
            $image = new  Image();
            $image->setCaption($faker->sentence())
                   ->setAd($ad)
                   ->setUrlImage($faker->imageUrl());
            $manager->persist($image);
        }
        $manager->flush();
    }
}
}
