<?php

namespace App\Controller\Comment;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

readonly class GetCommentCollectionAction
{
    public function __construct(
        private CommentRepository $repository,
        private CacheService $cacheService
    ) {
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

        $idCache = "getCommentCollectionAction";
        if ($status) {
            $idCache .= "-" . $status;
        }

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "commentCache",
            function() use ($criteria) {
                return $this->repository->findBy($criteria);
            },
            'getCommentCollection',
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