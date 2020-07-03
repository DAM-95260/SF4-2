<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
use Faker\Factory;

class ProductFixtures extends Fixture implements  DependentFixtureInterface
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

           // Récupération aléatoire d'une catégorie par une référence
           $categoryReference = 'category_' .  $faker->numberBetween(0, 2);
           /** @var Category $category */
           $category = $this->getReference($categoryReference);
           $product->setCategory($category);

           $manager->persist($product);

            $manager->persist($product);
       }

       $manager->flush();
    }



    public function getDependencies()
    {
        return [
            CategoryFixturses::class
        ];
    }
}
