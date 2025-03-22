<?php

namespace App\Service;

use App\Repository\GameRepository;
use App\Repository\NewsRepository;
use App\Repository\ReviewRepository;
use Doctrine\Persistence\ObjectRepository;

class RepositoryRegistry
{
    private array $repositories = [];

    public function __construct(
        private readonly NewsRepository   $newsRepository,
        private readonly ReviewRepository $reviewRepository,
        private readonly GameRepository $gameRepository
    ) {

        $this->repositories = [
            'news' => $this->newsRepository,
            'review' => $this->reviewRepository,
            'game' => $this->gameRepository
        ];
    }

    public function getRepositoryForCategory(string $category): ?ObjectRepository
    {
        return $this->repositories[$category] ?? null;
    }

    public function getSupportedCategories(): array
    {
        return array_keys($this->repositories);
    }
}