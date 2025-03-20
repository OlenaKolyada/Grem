<?php

namespace App\Controller\Comment;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;

readonly class DeleteCommentAction
{
    public function __construct(
        private EntityManagerInterface $manager,
        private TagAwareCacheInterface $cache
    ) {
    }

    #[Route('/api/comment/{id}', name: 'app_delete_comment_item', methods: ['DELETE'])]
    #[IsGranted('ROLE_USER', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 204, description: "Comment item successfully deleted")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Response(response: 404, description: "Comment not found")]
    #[OA\Parameter(name: "id", description: "Comment ID", in: "path",
        required: true, schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "Comment")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Comment $comment): Response
    {
        $this->cache->invalidateTags(["commentCache"]);
        $this->manager->remove($comment);
        $this->manager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}