<?php

namespace App\DataFixtures;

use App\Entity\Comment;
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

        // Количество пользователей (5)
        $userCount = 5;

        // Для каждого пользователя создаем комментарии
        for ($userId = 1; $userId <= $userCount; $userId++) {
            // Количество комментариев для каждого пользователя (от 3 до 7)
            $commentCount = rand(3, 7);

            for ($i = 0; $i < $commentCount; $i++) {
                $comment = new Comment();
                $comment
                    ->setContent($faker->text(50))
                    ->setStatus($faker->randomElement(CommentStatusEnum::cases()))
                    ->setAuthor($this->getReference('user_' . $userId))
                    ->setReview($this->getReference('review_' . rand(0, 29)));

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