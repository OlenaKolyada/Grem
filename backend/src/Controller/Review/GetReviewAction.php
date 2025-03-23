<?php

namespace App\Controller\Review;

use App\Controller\Abstract\AbstractGetEntityAction;
use App\Entity\Review;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetReviewAction extends AbstractGetEntityAction
{
    public function __construct(
        protected readonly CacheService $cacheService
    ) {
        parent::__construct($cacheService);
    }
    #[Route('/api/review/{id}', name: 'app_get_review_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Review item",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Review::class,
                    groups: ["getReview"]
                ))))]
    #[OA\Parameter(name: "id",
        description: "Review ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Tag(name: "Review")]
    public function __invoke(Review $review): JsonResponse
    {
        return $this->getEntityData(
            $review,
            'Review',
            'review',
            'getReview',
            ['review']
        );
    }
}