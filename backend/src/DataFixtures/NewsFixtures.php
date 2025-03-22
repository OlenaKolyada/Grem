<?php

namespace App\DataFixtures;

use App\Entity\News;
use App\Entity\User;
use App\Entity\Tag;
use App\Entity\Game;
use App\Enum\StatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\AsciiSlugger;

class NewsFixtures extends Fixture implements DependentFixtureInterface
{
    use EntityHelperTrait;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $slugger = new AsciiSlugger();

        $otherStatuses = [
            StatusEnum::Draft,
            StatusEnum::Deleted,
            StatusEnum::Archived
        ];

        shuffle($otherStatuses);

        for ($i = 0; $i < 30; $i++) {
            $news = new News();

            if ($i < 22) {
                $status = StatusEnum::Published;
            } elseif ($i < 25) {
                $status = $otherStatuses[$i - 22];
            } else {
                $status = $faker->randomElement([
                    StatusEnum::Draft,
                    StatusEnum::Deleted,
                    StatusEnum::Archived
                ]);
            }

            $title = ucwords(rtrim($faker->sentence(), '.'));
            $slug = strtolower($slugger->slug($title));

            $createdAt = $faker->dateTimeBetween('2025-01-01', '2025-03-01');
            $updatedDays = $faker->numberBetween(1, 30);
            $updatedAt = (clone $createdAt)->modify("+$updatedDays days");

            $news
                ->setTitle($title)
                ->setStatus($status)
                ->setSlug($slug)
                ->setAuthor($this->getReference('user_' . rand(1, 5), User::class))
                ->setContent($content = $faker->paragraphs(3, true))
                ->setSummary(mb_substr($content, 0, 150) . '...')
                ->setCover('cover.jpg')
                ->setCreatedAt($createdAt)
                ->setUpdatedAt($updatedAt);

            // ✅ Исправлено: ключи соответствуют методам (addTag, addGame)
            $entityTypes = [
                'tag' => Tag::class,
                'game' => Game::class,
            ];
            $this->addRandomEntities($manager, $news, $entityTypes);

            $manager->persist($news);
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
