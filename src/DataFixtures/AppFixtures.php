<?php

namespace App\DataFixtures;

use App\Entity\Annonces;
use App\Entity\Categories;
use App\Entity\Regions;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use PhpParser\Node\Expr\Array_;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create('fr_FR');


        $annonces = Array();
        for($i = 0; $i<100; $i++){

            $annonces[$i] = new Annonces();
            $categories = new Categories();
            $regions = new Regions();
            $randCategories=strval(array(['bonjour', 'Aurevoir', 'Salut'],1));

            $annonces[$i]->setNomAnnonce($faker->word);
            $annonces[$i]->setDescriptionAnnonce($faker->sentence(25, true));
            $annonces[$i]->setPrixAnnonce($faker->randomFloat(2,0,21000));
            $annonces[$i]->setPhotoAnnonce("https://picsum.photos/200/300");
            $annonces[$i]->setCategorieAnnonce($categories->setNameCategorie((array)$randCategories));
            $annonces[$i]->setRegionAnnonce($regions->setNameRegion('regions'));
            $manager->persist($annonces[$i]);
        }
        $manager->flush();
    }
}
