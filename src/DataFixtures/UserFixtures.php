<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 15; $i++) {
            $user = new Users();
            $user->setName($faker->name);
            $user->setPassword($faker->password);
            $user->setBanStatus(false);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
