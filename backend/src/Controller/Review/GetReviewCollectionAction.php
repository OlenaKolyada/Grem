<?php

namespace App\Controller\Review;

use App\Controller\Abstract\AbstractCoreEntityCollectionAction;
use App\Entity\Review;
use App\Repository\ReviewRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetReviewCollectionAction extends AbstractCoreEntityCollectionAction
{
    public function __construct(
        ReviewRepository $repository,
        CacheService $cacheService
    ) {
        parent::__construct($repository, $cacheService);
    }

    #[Route('/api/review', name: 'api_get_review_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Review collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Review::class,
                    groups: ["getReviewCollection"]
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
        description: "Review status",
        in: "query",
        schema: new OA\Schema(
            type: "string",
            enum: ["Published", "Draft", "Archived", "Deleted"]
        ))]
    #[OA\Tag(name: "Review")]
    public function __invoke(Request $request): JsonResponse
    {
        return $this->getEntityData(
            $request,
            'Review',
            'review',
            'getReviewCollection',
            ['review']
        );
    }
}