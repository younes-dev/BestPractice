<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($loop = 1; $loop <= 10; ++$loop) {
            $category = new Category();
            $category->setName('sport');
            $manager->persist($category);

            for ($i = 0; $i < 10; ++$i) {
                $article = (new Article())->setAuthor($faker->name())
                    ->setContent($faker->text(300))
                    ->setCategory($category)
                    ->setName($faker->name())
                    ->setCreatedAt($faker->dateTime())
                    ->setUpdatedAt($faker->dateTime())
                ;
                $manager->persist($article);
            }
        }

        $manager->flush();
    }
}
