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
use Symfony\Component\Serializer\SerializerInterface;

readonly class ResolveSlugController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer
    ) {
    }

    #[OA\Tag(name: "API")]
    #[Route('/api/{entityType}/resolve/{slug}', name: 'app_resolve_slug', methods: ['GET'])]
    public function __invoke(string $entityType, string $slug): JsonResponse
    {
        $entityClass = $this->getEntityClassByType($entityType);
        $entity = $this->entityManager->getRepository($entityClass)->findOneBy(['slug' => $slug]);

        if (!$entity) {
            return new JsonResponse(['error' => 'Entity not found'], Response::HTTP_NOT_FOUND);
        }

        // Определим группы сериализации
        $groups = $this->getSerializationGroups($entityType);

        // Сериализуем и возвращаем полную сущность
        $json = $this->serializer->serialize($entity, 'json', ['groups' => $groups]);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    private function getEntityMapping(): array
    {
        return [
            'developer' => [
                'class' => Developer::class,
                'groups' => [Developer::GROUP_GET_DEVELOPER]
            ],
            'publisher' => [
                'class' => Publisher::class,
                'groups' => [Publisher::GROUP_GET_PUBLISHER]
            ],
            'genre' => [
                'class' => Genre::class,
                'groups' => [Genre::GROUP_GET_GENRE]
            ],
            'platform' => [
                'class' => Platform::class,
                'groups' => [Platform::GROUP_GET_PLATFORM]
            ],
            'tag' => [
                'class' => Tag::class,
                'groups' => [Tag::GROUP_GET_TAG]
            ],
            'game' => [
                'class' => Game::class,
                'groups' => [Game::GROUP_GET_GAME]
            ],
            'news' => [
                'class' => News::class,
                'groups' => [News::GROUP_GET_NEWS]
            ],
            'review' => [
                'class' => Review::class,
                'groups' => [Review::GROUP_GET_REVIEW]
            ],
        ];
    }

    private function getEntityClassByType(string $type): string
    {
        $mapping = $this->getEntityMapping();

        if (!isset($mapping[$type])) {
            throw new \InvalidArgumentException("Unknown entity type: $type");
        }

        return $mapping[$type]['class'];
    }

    private function getSerializationGroups(string $entityType): array
    {
        $mapping = $this->getEntityMapping();
        return $mapping[$entityType]['groups'] ?? [];
    }
}