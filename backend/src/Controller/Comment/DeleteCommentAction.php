<?php

namespace App\Controller\Comment;

use App\Controller\Abstract\AbstractDeleteEntityAction;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

class DeleteCommentAction extends AbstractDeleteEntityAction
{
    public function __construct(
        protected readonly EntityManagerInterface $manager,
        protected readonly TagAwareCacheInterface $cache
    ) {
        parent::__construct($manager, $cache);
    }

    #[Route('/api/comment/{id}', name: 'app_delete_comment_item', methods: ['DELETE'])]
    #[IsGranted('ROLE_USER', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 204, description: "Comment item successfully deleted")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Response(response: 404, description: "Comment not found")]
    #[OA\Parameter(name: "id", description: "Comment ID", in: "path",
        required: true, schema: new OA\Schema(type: "integer")
    )]
    #[OA\Tag(name: "Comment")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Comment $comment): Response
    {
        return $this->deleteEntity($comment, "commentCache");
    }
}