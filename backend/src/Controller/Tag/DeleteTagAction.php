<?php

namespace App\Controller\Tag;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

readonly class DeleteTagAction
{
    public function __construct(
        private EntityManagerInterface $manager,
        private TagAwareCacheInterface $cache
    ) {
    }
    #[Route('/api/tag/{id}', name: 'app_delete_tag', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 204, description: "Tag item successfully deleted")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Response(response: 404, description: "Tag not found")]
    #[OA\Parameter(name: "id", description: "Tag ID",in: "path",
        required: true, schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "Tag")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Tag $tag): JsonResponse
    {
        $this->cache->invalidateTags(["tagCache"]);
        $this->manager->remove($tag);
        $this->manager->flush();

        return new JsonResponse(
            null,
            Response::HTTP_NO_CONTENT
        );
    }
}