<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Instanciation de Faker
        $faker = Factory::create('fr_FR');

       // Générer 50 produits
       for ($i = 0; $i < 50; $i++){
           $product = new Product();
           $product
            ->setName($faker->sentence(3))
            ->setDescription($faker->optional()->realText())
            ->setPrice($faker->numberBetween(1000, 35000))
            ->setCreatedAt($faker->dateTimeBetween('-6 months'))
            ;

            $manager->persist($product);
       }

       $manager->flush();
    }
}
