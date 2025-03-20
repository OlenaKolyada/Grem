<?php

namespace App\Controller\Review;

use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;

readonly class DeleteReviewAction
{
    public function __construct(
        private EntityManagerInterface $manager,
        private TagAwareCacheInterface $cache
    ) {
    }

    #[Route('/api/review/{id}', name: 'app_delete_review_item', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 204, description: "Review item successfully deleted")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Response(response: 404, description: "Review not found")]
    #[OA\Parameter(name: "id", description: "Review ID", in: "path",
        required: true, schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "Review")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Review $review): Response
    {
        $this->cache->invalidateTags(["reviewCache"]);
        $this->manager->remove($review);
        $this->manager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}