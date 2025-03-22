<?php

namespace App\Controller\Publisher;

use App\Entity\Publisher;
use App\Repository\PublisherRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

readonly class GetPublisherCollectionAction
{
    public function __construct(
        private PublisherRepository $repository,
        private CacheService $cacheService
    ) {
    }
    #[Route('/api/publisher', name: 'app_get_publisher_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Publisher collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Publisher::class,
                    groups: ["getPublisherCollection"]))))]
    #[OA\Tag(name: "Publisher")]
    public function __invoke(): JsonResponse
    {
        $idCache = "getPublisherCollectionAction";

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "publisherCache",
            function() {
                return $this->repository->findAll();
            },
            'getPublisherCollection',
            ['publisher']
        );

        return new JsonResponse(
            $jsonData,
            Response::HTTP_OK,
            [],
            true
        );
    }
}