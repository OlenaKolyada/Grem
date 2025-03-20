<?php

namespace App\Controller\Tag;

use App\Entity\Tag;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

readonly class GetTagAction
{
    public function __construct(
        private CacheService $cacheService
    ) {
    }

    #[Route('/api/tag/{id}', name: 'app_get_tag_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Tag item",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Tag::class,
                    groups: ["getTag"]))))]
    #[OA\Parameter(name: "id",
        description: "Tag ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "Tag")]
    public function __invoke(Tag $tag): JsonResponse
    {
        $idCache = "getTagAction-" . $tag->getId();

        $jsonTag = $this->cacheService->getCachedData(
            $idCache,
            "tagCache",
            function() use ($tag) {
                return $tag;
            },
            'getTag',
            ['tag']
        );

        return new JsonResponse(
            $jsonTag,
            Response::HTTP_OK,
            [],
            true
        );
    }
}