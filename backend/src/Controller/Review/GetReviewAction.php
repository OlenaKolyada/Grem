<?php

namespace App\Controller\Review;

use App\Entity\Review;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

readonly class GetReviewAction
{
    public function __construct(
        private CacheService $cacheService
    ) {
    }

    #[Route('/api/review/{id}', name: 'app_get_review_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Review item",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Review::class,
                    groups: ["getReview"]))))]
    #[OA\Parameter(name: "id",
        description: "Review ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "Review")]
    public function __invoke(Review $review): JsonResponse
    {
        $idCache = "getReviewAction-" . $review->getId();

        $jsonReview = $this->cacheService->getCachedData(
            $idCache,
            "reviewCache",
            function() use ($review) {
                return $review;
            },
            'getReview',
            ['review']
        );

        return new JsonResponse(
            $jsonReview,
            Response::HTTP_OK,
            [],
            true
        );
    }
}