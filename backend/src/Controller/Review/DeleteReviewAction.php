<?php

namespace App\Controller\Review;

use App\Controller\Abstract\AbstractDeleteEntityAction;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

class DeleteReviewAction extends AbstractDeleteEntityAction
{
    public function __construct(
        protected readonly EntityManagerInterface $manager,
        protected readonly TagAwareCacheInterface $cache
    ) {
        parent::__construct($manager, $cache);
    }

    #[Route('/api/review/{id}', name: 'app_delete_review_item', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 204, description: "Review item successfully deleted")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Response(response: 404, description: "Review not found")]
    #[OA\Parameter(name: "id", description: "Review ID", in: "path",
        required: true, schema: new OA\Schema(type: "integer")
    )]
    #[OA\Tag(name: "Review")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Review $review): Response
    {
        return $this->deleteEntity($review, "reviewCache");
    }
}