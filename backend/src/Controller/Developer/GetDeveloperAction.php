<?php

namespace App\Controller\Developer;

use App\Entity\Developer;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

readonly class GetDeveloperAction
{
    public function __construct(
        private CacheService $cacheService
    ) {
    }

    #[Route('/api/developer/{id}', name: 'app_get_developer_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Developer item",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Developer::class,
                    groups: ["getDeveloper"]))))]
    #[OA\Parameter(name: "id",
        description: "Developer ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "Developer")]
    public function __invoke(Developer $developer): JsonResponse
    {
        $idCache = "getDeveloperAction-" . $developer->getId();

        $jsonDeveloper = $this->cacheService->getCachedData(
            $idCache,
            "developerCache",
            function() use ($developer) {
                return $developer;
            },
            'getDeveloper',
            ['developer']
        );

        return new JsonResponse(
            $jsonDeveloper,
            Response::HTTP_OK,
            [],
            true
        );
    }
}