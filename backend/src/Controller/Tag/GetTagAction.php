<?php

namespace App\Controller\Tag;

use App\Controller\Abstract\AbstractGetEntityAction;
use App\Entity\Tag;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetTagAction extends AbstractGetEntityAction
{
    public function __construct(
        CacheService $cacheService
    ) {
        parent::__construct($cacheService);
    }

    #[Route('/api/tag/{id}', name: 'app_get_tag_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Tag item",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Tag::class,
                    groups: ["getTag"]
                ))))]
    #[OA\Parameter(name: "id",
        description: "Tag ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Tag(name: "Tag")]
    public function __invoke(Tag $tag): JsonResponse
    {
        return $this->getEntityData(
            $tag,
            'Tag',
            'tag',
            'getTag',
            ['tag']
        );
    }
}