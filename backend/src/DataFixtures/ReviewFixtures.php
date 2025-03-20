<?php

namespace App\DataFixtures;

use App\Entity\Review;
use App\Enum\StatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ReviewFixtures extends Fixture implements DependentFixtureInterface
{
    use EntityHelperTrait;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $slugger = new AsciiSlugger();

        // Другие статусы, которые нужно распределить
        $otherStatuses = [
            StatusEnum::Draft,
            StatusEnum::Deleted,
            StatusEnum::Archived
        ];

        // Перемешиваем, чтобы распределение было случайным
        shuffle($otherStatuses);

        for ($i = 0; $i < 30; $i++) {
            $review = new Review();

            // Первые 22 обзора получают статус Published
            if ($i < 22) {
                $status = StatusEnum::Published;
            }
            // Следующие 3 обзора получают оставшиеся статусы (по одному каждого)
            elseif ($i < 25) {
                $status = $otherStatuses[$i - 22];
            }
            // Остальные 5 обзоров получают случайные статусы
            else {
                $status = $faker->randomElement([
                    StatusEnum::Draft,
                    StatusEnum::Deleted,
                    StatusEnum::Archived
                ]);
            }

            $title = ucwords(rtrim($faker->sentence(), '.'));
            $slug = strtolower($slugger->slug($title));

            // Создаем случайные даты
            $createdAt = $faker->dateTimeBetween('2025-01-01', '2025-03-01');
            $updatedDays = $faker->numberBetween(1, 30);
            $updatedAt = (clone $createdAt)->modify("+$updatedDays days");

            $review
                ->setTitle($title)
                ->setStatus($status)
                ->setSlug($slug)
                ->setAuthor($this->getReference('user_' . rand(1, 5)))
                ->setContent($content = $faker->paragraphs(3, true))
                ->setSummary(mb_substr($content, 0, 150) . '...')
                ->setCover('cover.jpg')
                ->setGameRating(rand(1, 10))
                ->setCreatedAt($createdAt)
                ->setUpdatedAt($updatedAt);

            $entityTypes = ['tag', 'game'];
            $this->addRandomEntities($manager, $review, $entityTypes);

            $manager->persist($review);
            $this->addReference('review_' . $i, $review);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TagFixtures::class,
            GameFixtures::class,
            UserFixtures::class
        ];
    }
}