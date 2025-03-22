<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Review;
use App\Entity\Tag;
use App\Entity\User;
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

        $otherStatuses = [
            StatusEnum::Draft,
            StatusEnum::Deleted,
            StatusEnum::Archived
        ];

        shuffle($otherStatuses);

        for ($i = 0; $i < 30; $i++) {
            $review = new Review();

            if ($i < 22) {
                $status = StatusEnum::Published;
            }
            elseif ($i < 25) {
                $status = $otherStatuses[$i - 22];
            }
            else {
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

            $review
                ->setTitle($title)
                ->setStatus($status)
                ->setSlug($slug)
                ->setAuthor($this->getReference('user_' . rand(1, 5), User::class))
                ->setContent($content = $faker->paragraphs(3, true))
                ->setSummary(mb_substr($content, 0, 150) . '...')
                ->setCover('cover.jpg')
                ->setGameRating(rand(1, 10));
//                ->setCreatedAt($createdAt)
//                ->setUpdatedAt($updatedAt);

            $entityTypes = [
                'tag' => Tag::class,
                'game' => Game::class,
            ];

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