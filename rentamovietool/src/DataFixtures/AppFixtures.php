<?php

namespace App\DataFixtures;

use App\Entity\Camera;
use App\Entity\Loueur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        $loueurs = [];

        //Cela concerne nos utilisateurs
        for($i= 1; $i <= 10; $i++){
            $loueur = new Loueur();

            $hash = $this->encoder->encodePassword($loueur, 'password');

            $loueur->setPrenom($faker->firstName)
                   ->setNom($faker->lastName)
                   ->setAdresse($faker->address)
                   ->setCodePostal($faker->postcode)
                   ->setVille($faker->city)
                   ->setEmail($faker->email)
                   ->setTelephone($faker->phoneNumber)
                   ->setPresentation(($faker->realText(50, 2)))
                   ->setHash($hash);

            $manager->persist($loueur);
            $loueurs[] = $loueur;

        }

        // Cela concerne les cameras
        for($i=1; $i <= 21; $i++){
        $camera = new Camera();
        $marque = $faker->company;
        $modele = $faker->ean8;
        $image = $faker->imageUrl();
        $description = $faker->paragraph(3);
        $loueur = $loueurs[mt_rand(0, count($loueurs)-1)];
        $camera->setMarque("$marque")
               ->setModele("$modele" )
               ->setDescription("$description")
               ->setImage($image)
               ->setPrix(mt_rand(40, 800))
               ->setLoueur($loueur);
        $manager->persist($camera);
        }

        $manager->flush();
    }
}
