<?php

namespace App\Controller\Game;

use App\Controller\Abstract\AbstractGetCoreEntityCollectionAction;
use App\Entity\Game;
use App\Repository\GameRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetGameCollectionActionGet extends AbstractGetCoreEntityCollectionAction
{
    public function __construct(
        GameRepository $repository,
        CacheService $cacheService
    ) {
        parent::__construct($repository, $cacheService);
    }
    #[Route('/api/game', name: 'api_get_game_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Game collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Game::class,
                    groups: ["getGameCollection"]
                ))))]
    #[OA\Parameter(name: "page",
        description: "Page number",
        in: "query",
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Parameter(name: "limit",
        description: "Number of items per page",
        in: "query",
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Parameter(
        name: "sort",
        description: "Sorting format: field:direction (e.g. updatedAt:desc)",
        in: "query",
        schema: new OA\Schema(
            type: "string",
            example: "updatedAt:desc")
    )]
    #[OA\Parameter( name: "status",
        description: "Game status",
        in: "query",
        schema: new OA\Schema(
            type: "string",
            enum: ["Published", "Draft", "Archived", "Deleted"]
        ))]
    #[OA\Tag(name: "Game")]
    public function __invoke(Request $request): JsonResponse
    {
        return $this->getEntityData(
            $request,
            'Game',
            'game',
            'getGameCollection',
            ['game']
        );
    }
}