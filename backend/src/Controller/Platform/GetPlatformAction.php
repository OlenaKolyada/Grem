<?php

namespace App\Controller\Platform;

use App\Entity\Platform;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

readonly class GetPlatformAction
{
    public function __construct(
        private CacheService $cacheService
    ) {
    }

    #[Route('/api/platform/{id}', name: 'app_get_platform_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Platform item",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Platform::class,
                    groups: ["getPlatform"]))))]
    #[OA\Parameter(name: "id",
        description: "Platform ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "Platform")]
    public function __invoke(Platform $platform): JsonResponse
    {
        $idCache = "getPlatformAction-" . $platform->getId();

        $jsonPlatform = $this->cacheService->getCachedData(
            $idCache,
            "platformCache",
            function() use ($platform) {
                return $platform;
            },
            'getPlatform',
            ['platform']
        );

        return new JsonResponse(
            $jsonPlatform,
            Response::HTTP_OK,
            [],
            true
        );
    }
}