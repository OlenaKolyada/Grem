<?php

namespace App\Service\EntityField\Configuration;

use App\Repository\CommentRepository;
use App\Repository\DeveloperRepository;
use App\Repository\GameRepository;
use App\Repository\GenreRepository;
use App\Repository\NewsRepository;
use App\Repository\PlatformRepository;
use App\Repository\PublisherRepository;
use App\Repository\ReviewRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;

readonly class EntityConfigurationFactory implements EntityConfigurationFactoryInterface
{
    public function __construct(
        private CommentRepository   $commentRepository,
        private DeveloperRepository $developerRepository,
        private GameRepository      $gameRepository,
        private GenreRepository     $genreRepository,
        private NewsRepository      $newsRepository,
        private PlatformRepository  $platformRepository,
        private PublisherRepository $publisherRepository,
        private ReviewRepository    $reviewRepository,
        private TagRepository       $tagRepository,
        private UserRepository      $userRepository
    ) {
    }

    public function create(string $entityType): array
    {
        return match ($entityType) {
            'comment' => $this->createCommentConfig(),
            'developer' => $this->createDeveloperConfig(),
            'game' => $this->createGameConfig(),
            'genre' => $this->createGenreConfig(),
            'news' => $this->createNewsConfig(),
            'platform' => $this->createPlatformConfig(),
            'publisher' => $this->createPublisherConfig(),
            'review' => $this->createReviewConfig(),
            'tag' => $this->createTagConfig(),
            'user' => $this->createUserConfig(),
            default => throw new \InvalidArgumentException("Unsupported entity type: {$entityType}")
        };
    }

    private function createCommentConfig(): array
    {
        return [
            'required' => ['content', 'status'],
            'optional' => ['country', 'website'],
            'relations' => [
                'author' => $this->createEntityRelation($this->userRepository),
                'review' => $this->createEntityRelation($this->reviewRepository)
            ]
        ];
    }

    private function createDeveloperConfig(): array
    {
        return [
            'required' => ['title'],
            'optional' => ['slug', 'country', 'website'],
            'relations' => [
                'game' => $this->createCollectionRelation($this->gameRepository),
            ]
        ];
    }

    private function createGameConfig(): array
    {
        return [
            'required' => ['title', 'content', 'summary', 'status', 'platformRequirementsLevel', 'ageRating'],
            'optional' => ['slug', 'cover', 'language', 'website', 'releaseDateWorld', 'releaseDateFrance'],
            'relations' => [
                'developer' => $this->createCollectionRelation($this->developerRepository),
                'genre' => $this->createCollectionRelation($this->genreRepository),
                'platform' => $this->createCollectionRelation($this->platformRepository),
                'publisher' => $this->createCollectionRelation($this->publisherRepository),
                'news' => $this->createCollectionRelation($this->newsRepository),
                'review' => $this->createCollectionRelation($this->reviewRepository),
            ]
        ];
    }

    private function createGenreConfig(): array
    {
        return [
            'required' => ['title'],
            'optional' => ['slug'],
            'relations' => [
                'game' => $this->createCollectionRelation($this->gameRepository),
            ]
        ];
    }

    private function createNewsConfig(): array
    {
        return [
            'required' => ['title', 'content', 'summary', 'status'],
            'optional' => ['slug', 'cover'],
            'relations' => [
                'author' => $this->createEntityRelation($this->userRepository, true),
                'tag' => $this->createCollectionRelation($this->tagRepository),
                'game' => $this->createCollectionRelation($this->gameRepository)
            ]
        ];
    }

    private function createPlatformConfig(): array
    {
        return [
            'required' => ['title'],
            'optional' => ['slug'],
            'relations' => [
                'game' => $this->createCollectionRelation($this->gameRepository),
            ]
        ];
    }

    private function createPublisherConfig(): array
    {
        return [
            'required' => ['title'],
            'optional' => ['slug', 'country', 'website'],
            'relations' => [
                'game' => $this->createCollectionRelation($this->gameRepository),
            ]
        ];
    }

    private function createReviewConfig(): array
    {
        return [
            'required' => ['title', 'content', 'summary', 'status'],
            'optional' => ['slug', 'gameRating', 'cover'],
            'relations' => [
                'author' => $this->createEntityRelation($this->userRepository, true),
                'tag' => $this->createCollectionRelation($this->tagRepository),
                'game' => $this->createEntityRelation($this->gameRepository, true)
            ]
        ];
    }

    private function createTagConfig(): array
    {
        return [
            'required' => ['title'],
            'optional' => ['slug'],
            'relations' => [
                'news' => $this->createCollectionRelation($this->newsRepository),
                'review' => $this->createCollectionRelation($this->reviewRepository),
            ]
        ];
    }

    private function createUserConfig(): array
    {
        return [
            'required' => ['nickname', 'email', 'password', 'roles'],
            'optional' => ['avatar', 'twitchAccount'],
            'relations' => [
                'news' => $this->createCollectionRelation($this->newsRepository),
                'review' => $this->createCollectionRelation($this->reviewRepository),
                'comment' => $this->createCollectionRelation($this->commentRepository),
            ]
        ];
    }

    private function createCollectionRelation(object $repository, bool $required = false): array
    {
        return [
            'type' => 'collection',
            'repository' => $repository,
            'numericField' => 'id',
            'stringField' => 'title',
            'required' => $required,
            'clearExisting' => true
        ];
    }

    private function createEntityRelation(object $repository, bool $required = false): array
    {
        return [
            'type' => 'entity',
            'repository' => $repository,
            'numericField' => 'id',
            'stringField' => 'title',
            'required' => $required
        ];
    }
}