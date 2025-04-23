<?php

namespace App\Controller\News;

use App\Controller\Abstract\AbstractGetCoreEntityCollectionAction;
use App\Entity\News;
use App\Repository\NewsRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetNewsCollectionActionGet extends AbstractGetCoreEntityCollectionAction
{
    public function __construct(
        NewsRepository $repository,
        CacheService $cacheService
    ) {
        parent::__construct($repository, $cacheService);
    }

    #[Route('/api/news', name: 'app_get_news_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a News collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: News::class,
                    groups: ["getNewsCollection"]
                ))))]
    #[OA\Parameter(
        name: "page",
        description: "Page number",
        in: "query",
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Parameter(
        name: "limit",
        description: "Number of items per page",
        in: "query",
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Parameter(
        name: "sort",
        description: "Sorting format: field:direction (e.g. updatedAt:desc)",
        in: "query",
        schema: new OA\Schema(
            type: "string",
            example: "updatedAt:desc")
    )]
    #[OA\Parameter(
        name: "status",
        description: "News status",
        in: "query",
        schema: new OA\Schema(
            type: "string",
            enum: ["Published", "Draft", "Archived", "Deleted"]
        ))]
    #[OA\Tag(name: "News")]
    public function __invoke(Request $request): JsonResponse
    {
        return $this->getEntityData(
            $request,
            'News',
            'news',
            'getNewsCollection',
            ['news']
        );
    }
}