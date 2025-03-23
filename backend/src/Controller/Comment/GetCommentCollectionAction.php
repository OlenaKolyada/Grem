<?php

namespace App\Controller\Comment;

use App\Controller\Abstract\AbstractGetMetaEntityCollectionAction;
use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetCommentCollectionAction extends AbstractGetMetaEntityCollectionAction
{
    public function __construct(
        CommentRepository $repository,
        CacheService $cacheService
    ) {
        parent::__construct($repository, $cacheService);
    }

    #[Route('/api/comment', name: 'api_get_comment_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Comment collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Comment::class,
                    groups: ["getCommentCollection"]))))]
    #[OA\Parameter(name: "status",
        description: "Comment status",
        in: "query",
        schema: new OA\Schema(
            type: "string",
            enum: ["Published", "Edited", "Deleted"]))]
    #[OA\Tag(name: "Comment")]
    public function __invoke(Request $request): JsonResponse
    {
        $status = $request->query->get('status');
        $criteria = [];

        if ($status) {
            $criteria['status'] = $status;
        }

        return $this->getEntityData(
            'Comment',
            'comment',
            'getCommentCollection',
            ['comment'],
            $criteria,
            $status
        );
    }
}