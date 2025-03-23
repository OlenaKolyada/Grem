<?php

namespace App\Controller\Platform;

use App\Controller\Abstract\AbstractGetMetaEntityCollectionAction;
use App\Entity\Platform;
use App\Repository\PlatformRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetPlatformCollectionAction extends AbstractGetMetaEntityCollectionAction
{
    public function __construct(
        PlatformRepository $repository,
        CacheService $cacheService
    ) {
        parent::__construct($repository, $cacheService);
    }
    #[Route('/api/platform', name: 'app_get_platform_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Platform collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Platform::class,
                    groups: ["getPlatformCollection"]
                ))))]
    #[OA\Tag(name: "Platform")]
    public function __invoke(): JsonResponse
    {
        return $this->getEntityData(
            'Platform',
            'platform',
            'getPlatformCollection',
            ['platform']
        );
    }
}