<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

    private Generator $faker ;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR') ;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=1; $i <= mt_rand(8,10); $i++)
        { 
            $article = new Article ;
            $article->setTitle($this->faker->sentence(3))
                    ->setContent($this->faker->paragraph(20))
                    ->setImage($this->faker->imageURL(200,300))
                    ->setCreatedAt($this->faker->dateTimeBetween('-10 months')) ;
            $manager->persist($article) ;
        }
        $manager->flush();
    }
}
