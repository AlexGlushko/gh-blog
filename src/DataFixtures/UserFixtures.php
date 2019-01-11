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

        foreach ($this->getUsers() as list($username, $password)) {
            $user = new Users();
            $user->setName($username);
            $user->setPassword($password);
            $user->setBanStatus(false);

            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getUsers(): array
    {
        return [
                    ['Mr.Snowman', '123465789'],
                    ['Oddissman', 'Oddissman'],
                    ['Mr. Zadrot', 'zadrot123'],
                    ['MANDARIN', 'qwerty'],
        ];
    }
}
