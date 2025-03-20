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
        private NewsRepository $newsRepository,
        private ReviewRepository $reviewRepository,
        private GameRepository $gameRepository
    ) {
        // Инициализация маппинга категорий и репозиториев
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