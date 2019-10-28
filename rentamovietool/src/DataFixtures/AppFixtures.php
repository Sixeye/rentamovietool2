<?php

namespace App\DataFixtures;

use App\Entity\Camera;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for($i=1; $i <= 21; $i++){
        $camera = new Camera();
        $faker = Factory::create('fr-FR');
        $marque = $faker->company;
        $modele = $faker->ean8;
        $image = $faker->imageUrl();
        $description = $faker->paragraph(3);
        $camera->setMarque("$marque")
            ->setModele("$modele" )
            ->setDescription("$description")
            ->setImage($image)
            ->setPrix(mt_rand(40, 800));
        $manager->persist($camera);
        }

        $manager->flush();
    }
}
