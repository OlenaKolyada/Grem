<?php

namespace App\Controller\Comment;

use App\Entity\Comment;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

readonly class GetCommentAction
{
    public function __construct(
        private CacheService $cacheService
    ) {
    }

    #[Route('/api/comment/{id}', name: 'app_get_comment_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Comment item",
        content: new OA\JsonContent(
            ref: new Model(
                type: Comment::class,
                groups: ["getComment"])))]
    #[OA\Parameter(name: "id",
        description: "Comment ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "Comment")]
    public function __invoke(Comment $comment): JsonResponse
    {
        $idCache = "getCommentAction-" . $comment->getId();

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "commentCache",
            function() use ($comment) {
                return $comment;
            },
            'getComment',
            ['comment']
        );

        return new JsonResponse(
            $jsonData,
            Response::HTTP_OK,
            [],
            true
        );
    }
}