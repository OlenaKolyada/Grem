<?php

namespace App\Controller\Comment;

use App\Controller\Abstract\AbstractGetEntityAction;
use App\Entity\Comment;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetCommentAction extends AbstractGetEntityAction
{
    public function __construct(
        protected readonly CacheService $cacheService
    ) {
        parent::__construct($cacheService);
    }

    #[Route('/api/comment/{id}', name: 'app_get_comment_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Comment item",
        content: new OA\JsonContent(
            ref: new Model(
                type: Comment::class,
                groups: ["getComment"]
            )))]
    #[OA\Parameter(name: "id",
        description: "Comment ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Tag(name: "Comment")]
    public function __invoke(Comment $comment): JsonResponse
    {
        return $this->getEntityData(
            $comment,
            'Comment',
            'comment',
            'getComment',
            ['comment']
        );
    }
}