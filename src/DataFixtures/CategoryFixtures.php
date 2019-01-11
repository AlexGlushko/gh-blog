<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getCategory() as $index =>$name) {
            $category = new Category();
            $category->setName($name);
            $category->setIsEnabled(true);

            $manager->persist($category);
        }

        $manager->flush();
        $this->addReference('category', $category);
    }

    public function getCategory(): array
    {
        return [
            'Development',
            'Symfony',
            'Testing',
            'Analytics',
            'CMS',
            'Marketing',
            'Cases',
            'Leraning',
        ];
    }
}
