<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Enum\AgeRatingEnum;
use App\Enum\PlatformRequirementsLevelEnum;
use App\Enum\StatusEnum;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use Random\RandomException;
use Symfony\Component\String\Slugger\AsciiSlugger;

class GameFixtures extends Fixture implements DependentFixtureInterface
{
    use EntityHelperTrait;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $languages = ['en', 'fr', 'ru'];
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
            $game = new Game();

            // Первые 22 игры получают статус Published
            if ($i < 22) {
                $status = StatusEnum::Published;
            }
            // Следующие 3 игры получают оставшиеся статусы (по одному каждого)
            elseif ($i < 25) {
                $status = $otherStatuses[$i - 22];
            }
            // Остальные 5 игр получают случайные статусы
            else {
                $status = $faker->randomElement([
                    StatusEnum::Draft,
                    StatusEnum::Deleted,
                    StatusEnum::Archived
                ]);
            }

            $title = ucwords($faker->words(2, true));
            $slug = strtolower($slugger->slug($title));

            // Создаем случайные даты
            $createdAt = $faker->dateTimeBetween('2025-01-01', '2025-03-01');
            $updatedDays = $faker->numberBetween(1, 30);
            $updatedAt = (clone $createdAt)->modify("+$updatedDays days");

            $game
                ->setTitle($title)
                ->setStatus($status)
                ->setSlug($slug)
                ->setContent($content = $faker->paragraphs(3, true))
                ->setSummary(mb_substr($content, 0, 150) . '...')
                ->setReleaseDateWorld($faker->dateTimeBetween('-10 years', 'now'))
                ->setReleaseDateFrance($faker->dateTimeBetween('-10 years', 'now'))
                ->setPlatformRequirementsLevel($faker->randomElement(PlatformRequirementsLevelEnum::cases()))
                ->setAgeRating($faker->randomElement(AgeRatingEnum::cases()))
                ->setCover('cover.jpg')
                ->setWebsite($faker->url)
                ->setLanguage($faker->randomElements($languages, $faker->numberBetween(1, 3)))
                ->setCreatedAt($createdAt)
                ->setUpdatedAt($updatedAt);

            $entityTypes = ['developer', 'publisher', 'genre', 'platform'];
            $this->addRandomEntities($manager, $game, $entityTypes);

            $manager->persist($game);
            $this->addReference('game_' . $i, $game);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            DeveloperFixtures::class,
            PublisherFixtures::class,
            GenreFixtures::class,
            PlatformFixtures::class
        ];
    }
}