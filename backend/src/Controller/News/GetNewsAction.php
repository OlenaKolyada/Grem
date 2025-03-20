<?php

namespace App\Controller\News;

use App\Entity\News;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

readonly class GetNewsAction
{
    public function __construct(
        private CacheService $cacheService
    ) {
    }

    #[Route('/api/news/{id}', name: 'app_get_news_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a News item",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: News::class,
                    groups: ["getNews"]))))]
    #[OA\Parameter(name: "id",
        description: "News ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "News")]
    public function __invoke(News $news): JsonResponse
    {
        $idCache = "getNewsAction-" . $news->getId();

        $jsonNews = $this->cacheService->getCachedData(
            $idCache,
            "newsCache",
            function() use ($news) {
                return $news;
            },
            'getNews',
            ['news']
        );

        return new JsonResponse(
            $jsonNews,
            Response::HTTP_OK,
            [],
            true
        );
    }
}