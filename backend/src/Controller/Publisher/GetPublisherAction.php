<?php

namespace App\Controller\Publisher;

use App\Entity\Publisher;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

readonly class GetPublisherAction
{
    public function __construct(
        private CacheService $cacheService
    ) {
    }

    #[Route('/api/publisher/{id}', name: 'app_get_publisher_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Publisher item",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Publisher::class,
                    groups: ["getPublisher"]))))]
    #[OA\Parameter(name: "id",
        description: "Publisher ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "Publisher")]
    public function __invoke(Publisher $publisher): JsonResponse
    {
        $idCache = "getPublisherAction-" . $publisher->getId();

        $jsonPublisher = $this->cacheService->getCachedData(
            $idCache,
            "publisherCache",
            function() use ($publisher) {
                return $publisher;
            },
            'getPublisher',
            ['publisher']
        );

        return new JsonResponse(
            $jsonPublisher,
            Response::HTTP_OK,
            [],
            true
        );
    }
}