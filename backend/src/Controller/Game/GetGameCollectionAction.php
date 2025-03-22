<?php

namespace App\Controller\Game;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Service\CacheService;
use App\Trait\PaginationTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

readonly class GetGameCollectionAction
{
    use PaginationTrait;

    public function __construct(
        private GameRepository $repository,
        private CacheService $cacheService
    ) {
    }

    #[Route('/api/game', name: 'api_get_game_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Game collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Game::class,
                    groups: ["getGameCollection"]))))]
    #[OA\Parameter(name: "page",
        description: "Page number",
        in: "query",
        schema: new OA\Schema(type: "integer"))]
    #[OA\Parameter(name: "limit",
        description: "Number of items per page",
        in: "query",
        schema: new OA\Schema(type: "integer"))]
    #[OA\Parameter( name: "status",
        description: "Game status",
        in: "query",
        schema: new OA\Schema(
            type: "string",
            enum: ["Published", "Draft", "Archived", "Deleted"]))]
    #[OA\Tag(name: "Game")]
    public function __invoke(Request $request): JsonResponse
    {
        $pagination = $this->preparePaginationCriteria($request);

        $status = $pagination['criteria']['status'] ?? 'Published';
        $idCache = "getGameCollectionAction-" .
            $pagination['page'] . "-" . $pagination['limit'] . "-" . $status;

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "gameCache",
            function() use ($pagination) {
                return $this->repository->findByWithPagination(
                    $pagination['criteria'],
                    $pagination['page'],
                    $pagination['limit']
                );
            },
            'getGameCollection',
            ['game']
        );

        return new JsonResponse(
            $jsonData,
            Response::HTTP_OK,
            [],
            true
        );
    }
}