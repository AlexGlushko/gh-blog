<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
            $categoty = new Category();
            $categoty->setName('Category' . $i);
            $categoty->setIsEnabled(true);

            $manager->persist($categoty);
        }

        $manager->flush();
    }
}
