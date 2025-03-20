<?php

namespace App\Controller\Api;

use App\Entity\Developer;
use App\Entity\Game;
use App\Entity\Genre;
use App\Entity\News;
use App\Entity\Platform;
use App\Entity\Publisher;
use App\Entity\Review;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

readonly class ResolveSlugController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }
    #[OA\Tag(name: "API")]
    #[Route('/api/{entityType}/resolve/{slug}',
        name: 'app_resolve_slug',
        methods: ['GET']
    )]

    public function __invoke(string $entityType, string $slug): JsonResponse
    {
        // Если slug - число, интерпретируем его как ID
        if (is_numeric($slug)) {
            return new JsonResponse(['id' => (int)$slug]);
        }

        $entityClass = $this->getEntityClassByType($entityType);
        $entity = $this->entityManager->getRepository($entityClass)->findOneBy(['slug' => $slug]);

        if (!$entity) {
            return new JsonResponse(['error' => 'Entity not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['id' => $entity->getId()]);
    }

    private function getEntityClassByType(string $type): string
    {
        $mapping = [
            'developer' => Developer::class,
            'publisher' => Publisher::class,
            'genre' => Genre::class,
            'platform' => Platform::class,
            'tag' => Tag::class,
            'game' => Game::class,
            'news' => News::class,
            'review' => Review::class,
        ];

        if (!isset($mapping[$type])) {
            throw new \InvalidArgumentException("Unknown entity type: $type");
        }

        return $mapping[$type];
    }
}