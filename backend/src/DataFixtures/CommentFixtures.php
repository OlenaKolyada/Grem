<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Review;
use App\Entity\User;
use App\Enum\CommentStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $userCount = 5;

        for ($userId = 1; $userId <= $userCount; $userId++) {

            $commentCount = rand(3, 7);

            for ($i = 0; $i < $commentCount; $i++) {
                $comment = new Comment();
                $comment
                    ->setContent($faker->text(50))
                    ->setStatus($faker->randomElement(CommentStatusEnum::cases()))
                    ->setAuthor($this->getReference('user_' . $userId, User::class))
                    ->setReview($this->getReference('review_' . rand(0, 29),  Review::class));

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ReviewFixtures::class,
            UserFixtures::class,
        ];
    }
}