<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genres = ['Action', 'Adventure', 'RPG', 'Shooter',
            'Fighting', 'Strategy', 'Simulation',
            'Sports', 'Puzzle', 'Horror'];

        $slugger = new AsciiSlugger();

        foreach ($genres as $key => $title) {
            $genre = new Genre();
            $slug = strtolower($slugger->slug($title));

            $genre
                ->setTitle($title)
                ->setSlug($slug);

            $manager->persist($genre);
            $this->addReference('genre_' . $key, $genre);
        }
        $manager->flush();
    }
}