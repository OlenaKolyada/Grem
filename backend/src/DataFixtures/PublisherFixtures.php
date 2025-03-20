<?php

namespace App\DataFixtures;

use App\Entity\Publisher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Yaml\Yaml;

class PublisherFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $slugger = new AsciiSlugger();

        $yamlFile = __DIR__ . '/../../config/countries.yaml';
        $countriesData = Yaml::parseFile($yamlFile);
        $countries = array_column($countriesData['countries'], 'name');

        for ($i = 0; $i < 30; $i++) {
            $publisher = new Publisher();

            do {
                $word = $faker->unique()->word;
            } while (strlen($word) < 3);

            $title = ucwords($word);
            $slug = strtolower($slugger->slug($title));

            $publisher
                ->setTitle($title)
                ->setSlug($slug)
                ->setCountry($faker->randomElement($countries))
                ->setWebsite($faker->url);

            $manager->persist($publisher);
            $this->addReference('publisher_' . $i, $publisher);
        }

        $manager->flush();
    }
}