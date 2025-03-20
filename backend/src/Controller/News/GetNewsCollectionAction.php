<?php

namespace App\Controller\News;

use App\Entity\News;
use App\Repository\NewsRepository;
use App\Service\CacheService;
use App\Trait\PaginationTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

readonly class GetNewsCollectionAction
{
    use PaginationTrait;

    public function __construct(
        private NewsRepository $repository,
        private CacheService $cacheService
    ) {
    }

    #[Route('/api/news', name: 'api_get_news_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a News collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: News::class,
                    groups: ["getNewsCollection"]))))]
    #[OA\Parameter(
        name: "page",
        description: "Page number",
        in: "query",
        schema: new OA\Schema(type: "integer"))]
    #[OA\Parameter(
        name: "limit",
        description: "Number of items per page",
        in: "query",
        schema: new OA\Schema(type: "integer"))]
    #[OA\Parameter(
        name: "status",
        description: "News status",
        in: "query",
        schema: new OA\Schema(
            type: "string",
            enum: ["Published", "Draft", "Archived", "Deleted"]))]
    #[OA\Tag(name: "News")]
    public function __invoke(Request $request): JsonResponse
    {
        $pagination = $this->preparePaginationCriteria($request);

        $status = $pagination['criteria']['status'] ?? 'Published';
        $idCache = "getNewsCollectionAction-" .
            $pagination['page'] . "-" . $pagination['limit'] . "-" . $status;

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "newsCache",
            function() use ($pagination) {
                return $this->repository->findByWithPagination(
                    $pagination['criteria'],
                    $pagination['page'],
                    $pagination['limit']
                );
            },
            'getNewsCollection',
            ['news']
        );

        return new JsonResponse(
            $jsonData,
            Response::HTTP_OK,
            [],
            true
        );
    }
}