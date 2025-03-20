<?php

namespace App\Controller\Game;

use App\Entity\Game;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

readonly class GetGameAction
{
    public function __construct(
        private CacheService $cacheService
    ) {
    }

    #[Route('/api/game/{id}', name: 'app_get_game_item', methods: ['GET'])]
    #[OA\Response(response: 200, description: "Get a Game item",
        content: new OA\JsonContent(type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Game::class,
                    groups: ["getGame"]))))]
    #[OA\Parameter(name: "id",
        description: "Game ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "Game")]
    public function __invoke(Game $game): JsonResponse
    {
        $idCache = "getGameAction-" . $game->getId();

        $jsonGame = $this->cacheService->getCachedData(
            $idCache,
            "gameCache",
            function() use ($game) {
                return $game;
            },
            'getGame',
            ['game']
        );

        return new JsonResponse(
            $jsonGame,
            Response::HTTP_OK,
            [],
            true
        );
    }
}