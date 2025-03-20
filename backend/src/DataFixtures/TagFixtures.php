<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\AsciiSlugger;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $slugger = new AsciiSlugger();

        for ($i = 0; $i < 30; $i++) {
            $tag = new Tag();

            do {
                $word = $faker->unique()->word;
            } while (strlen($word) < 3);

            $title = ucwords($word);
            $slug = strtolower($slugger->slug($title));

            $tag
                ->setTitle($title)
                ->setSlug($slug);

            $manager->persist($tag);
            $this->addReference('tag_' . $i, $tag);
        }

        $manager->flush();
    }
}