<?php

namespace App\Controller\Developer;

use App\Controller\Abstract\AbstractGetEntityAction;
use App\Entity\Developer;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetDeveloperAction extends AbstractGetEntityAction
{
    public function __construct(
        protected readonly CacheService $cacheService
    ) {
        parent::__construct($cacheService);
    }

    #[Route('/api/developer/{id}', name: 'app_get_developer_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Developer item",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Developer::class,
                    groups: ["getDeveloper"]
                ))))]
    #[OA\Parameter(name: "id",
        description: "Developer ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Tag(name: "Developer")]
    public function __invoke(Developer $developer): JsonResponse
    {
        return $this->getEntityData(
            $developer,
            'Developer',
            'developer',
            'getDeveloper',
            ['developer']
        );
    }
}