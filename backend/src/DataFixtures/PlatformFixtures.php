<?php

namespace App\DataFixtures;

use App\Entity\Platform;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class PlatformFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $platforms = ['PS5', 'PS4', 'Xbox Series X/S', 'Xbox One',
            'Nintendo Switch', 'Windows', 'macOS', 'Linux', 'Android', 'iOS'];

        $slugger = new AsciiSlugger();

        foreach ($platforms as $key => $title) {
            $platform = new Platform();
            $slug = strtolower($slugger->slug($title));

            $platform
                ->setTitle($title)
                ->setSlug($slug);
            $manager->persist($platform);
            $this->addReference('platform_' . $key, $platform);
        }
        $manager->flush();
    }
}