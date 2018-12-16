<?php
/**
 * Created by PhpStorm.
 * User: halex
 * Date: 16.12.18
 * Time: 18:46
 */

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categories = $manager->getRepository(Category::class)->findAll();

        for ($i = 0; $i < 25; $i++) {
            $article = new Article();
            $article->setTitle('Title of article ' . $i);
            $article->setDescription('The description of article ' . $i);
            $article->setIsEnabled(true);
            $article->setCreatedAt(new \DateTime());
            $article->setUpdatedAt($article->getCreatedAt());

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
