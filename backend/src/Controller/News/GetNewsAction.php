<?php

namespace App\Controller\News;

use App\Controller\Abstract\AbstractGetEntityAction;
use App\Entity\News;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetNewsAction extends AbstractGetEntityAction
{
    public function __construct(
        protected readonly CacheService $cacheService
    ) {
        parent::__construct($cacheService);
    }
    #[Route('/api/news/{id}', name: 'app_get_news_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a News item",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: News::class,
                    groups: ["getNews"]
                ))))]
    #[OA\Parameter(name: "id",
        description: "News ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Tag(name: "News")]
    public function __invoke(News $news): JsonResponse
    {
        return $this->getEntityData(
            $news,
            'News',
            'news',
            'getNews',
            ['news']
        );
    }
}