<?php

namespace App\DataFixtures;

use App\Entity\News;
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

        // Другие статусы, которые нужно распределить
        $otherStatuses = [
            StatusEnum::Draft,
            StatusEnum::Deleted,
            StatusEnum::Archived
        ];

        // Перемешиваем, чтобы распределение было случайным
        shuffle($otherStatuses);

        for ($i = 0; $i < 30; $i++) {
            $news = new News();

            // Первые 22 новости получают статус Published
            if ($i < 22) {
                $status = StatusEnum::Published;
            }
            // Следующие 3 новости получают оставшиеся статусы (по одному каждого)
            elseif ($i < 25) {
                $status = $otherStatuses[$i - 22];
            }
            // Остальные 5 новостей получают случайные статусы
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

            $news
                ->setTitle($title)
                ->setStatus($status)
                ->setSlug($slug)
                ->setAuthor($this->getReference('user_' . rand(1, 5)))
                ->setContent($content = $faker->paragraphs(3, true))
                ->setSummary(mb_substr($content, 0, 150) . '...')
                ->setCover('cover.jpg')
                ->setCreatedAt($createdAt)
                ->setUpdatedAt($updatedAt);

            $entityTypes = ['tag', 'game'];
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