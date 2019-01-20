<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create();

        $testpass = 'qwerty';

        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@ghblog.loc');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setFirstName('Alex');
        $user->setLastName('Hlushko');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $testpass
        ));
        $manager->persist($user);
        $manager->flush();
        $this->addReference('user.admin', $user);
        unset($user);

        $user = new User();
        $user->setUsername('Picaka');
        $user->setEmail('writer@collins.com');
        $user->setRoles(['ROLE_WRITER']);
        $user->setFirstName('Dave');
        $user->setLastName('Collins');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $testpass
        ));
        $manager->persist($user);
        $manager->flush();
        $this->addReference('user.writer', $user);
        unset($user);


        foreach ($this->getUsers() as list($email, $password)) {
            $user = new User();
            $user->setUsername($email);
            $user->setEmail($password . '@gmail.com');
            $user->setRoles(['ROLE_USER']);
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                $password
            ));
            $manager->persist($user);

        }
        $manager->flush();


    }

    public function getUsers(): array
    {
        return [
                    ['Mr.Snowman', '123465789',],
                    ['Oddissman', 'Oddissman'],
                    ['Mr. Zadrot', 'zadrot123'],
                    ['MANDARIN', 'qwerty'],
        ];
    }
}
