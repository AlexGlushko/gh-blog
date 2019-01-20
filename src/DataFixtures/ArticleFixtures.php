<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $categories = $manager->getRepository(Category::class)->findAll();

        for ($i = 0; $i < 25; $i++) {
            $article = new Article();
            $article->setTitle($faker->realText(60, 2));
            $article->setDescription($faker->realText(240, 2));
            $article->setIsEnabled(true);
            $article->setCreatedAt(new \DateTime());
            $article->setUpdatedAt($article->getCreatedAt());
            $article->setText($faker->realText(1500, 2));
            //$article->addCategory($this->getReference('category'));

            foreach ($categories as $category) {
                $article->addCategory($category);
            }

            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [ CategoryFixtures::class ];
    }
}
