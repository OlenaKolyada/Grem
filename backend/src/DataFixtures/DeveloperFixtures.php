<?php

namespace App\DataFixtures;

use App\Entity\Developer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Yaml\Yaml;

class DeveloperFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $slugger = new AsciiSlugger();

        $yamlFile = __DIR__ . '/../../config/countries.yaml';
        $countriesData = Yaml::parseFile($yamlFile);
        $countries = array_column($countriesData['countries'], 'name');

        for ($i = 0; $i < 30; $i++) {
            $developer = new Developer();

            $title = ucwords($faker->firstName . ' ' . $faker->lastName);
            $slug = strtolower($slugger->slug($title));

            $developer
                ->setTitle($title)
                ->setSlug($slug)
                ->setCountry($faker->randomElement($countries))
                ->setWebsite($faker->url);

            $manager->persist($developer);
            $this->addReference('developer_' . $i, $developer);
        }

        $manager->flush();
    }
}