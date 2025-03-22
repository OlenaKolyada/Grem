<?php

namespace App\Controller\Review;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use App\Service\CacheService;
use App\Trait\PaginationTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

readonly class GetReviewCollectionAction
{
    use PaginationTrait;

    public function __construct(
        private ReviewRepository $repository,
        private CacheService $cacheService
    ) {
    }

    #[Route('/api/review', name: 'api_get_review_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Review collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Review::class,
                    groups: ["getReviewCollection"]))))]
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
        description: "Review status",
        in: "query",
        schema: new OA\Schema(
            type: "string",
            enum: ["Published", "Draft", "Archived", "Deleted"]))]
    #[OA\Tag(name: "Review")]
    public function __invoke(Request $request): JsonResponse
    {
        $pagination = $this->preparePaginationCriteria($request);

        $status = $pagination['criteria']['status'] ?? 'Published';
        $idCache = "getReviewCollectionAction-" .
            $pagination['page'] . "-" . $pagination['limit'] . "-" . $status;

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "reviewCache",
            function() use ($pagination) {
                return $this->repository->findByWithPagination(
                    $pagination['criteria'],
                    $pagination['page'],
                    $pagination['limit']
                );
            },
            'getReviewCollection',
            ['review']
        );

        return new JsonResponse(
            $jsonData,
            Response::HTTP_OK,
            [],
            true
        );
    }
}