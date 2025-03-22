<?php

namespace App\Controller\Platform;

use App\Entity\Platform;
use App\Repository\PlatformRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

readonly class GetPlatformCollectionAction
{
    public function __construct(
        private PlatformRepository $repository,
        private CacheService $cacheService
    ) {
    }
    #[Route('/api/platform', name: 'app_get_platform_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Platform collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Platform::class,
                    groups: ["getPlatformCollection"]))))]
    #[OA\Tag(name: "Platform")]
    public function __invoke(): JsonResponse
    {
        $idCache = "getPlatformCollectionAction";

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "platformCache",
            function() {
                return $this->repository->findAll();
            },
            'getPlatformCollection',
            ['platform']
        );

        return new JsonResponse(
            $jsonData,
            Response::HTTP_OK,
            [],
            true
        );
    }
}