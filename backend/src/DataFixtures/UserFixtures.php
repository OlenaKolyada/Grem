<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $users = [
            'Brie' => ['ROLE_ADMIN', 'ROLE_USER'],
            'Kai' => ['ROLE_USER'],
            'Sapphire' => ['ROLE_USER'],
            'Muse' => ['ROLE_USER'],
            'OneEyed' => ['ROLE_USER']
        ];

        $i = 1;
        foreach ($users as $name => $roles) {
            $user = new User();
            $email = strtolower($name) . '@gmail.com';

            $user
                ->setNickname($name)
                ->setEmail($email)
                ->setRoles($roles)
                ->setPassword($this->userPasswordHasher->hashPassword($user, 'password'))
                ->setTwitchAccount($faker->url)
                ->setAvatar('avatar.jpg');

            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
            $i++;
        }

        $manager->flush();
    }
}