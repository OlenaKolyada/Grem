<?php

namespace App\Controller\Platform;

use App\Controller\Abstract\AbstractGetEntityAction;
use App\Entity\Platform;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetPlatformAction extends AbstractGetEntityAction
{
    public function __construct(
        protected readonly CacheService $cacheService
    ) {
        parent::__construct($cacheService);
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
        return $this->getEntityData(
            $platform,
            'Platform',
            'platform',
            'getPlatform',
            ['platform']
        );
    }
}