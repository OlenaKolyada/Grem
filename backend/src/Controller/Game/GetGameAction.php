<?php

namespace App\Controller\Game;

use App\Controller\Abstract\AbstractGetEntityAction;
use App\Entity\Game;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetGameAction extends AbstractGetEntityAction
{
    public function __construct(
        CacheService $cacheService
    ) {
        parent::__construct($cacheService);
    }
    #[Route('/api/game/{id}', name: 'app_get_game_item', methods: ['GET'])]
    #[OA\Response(response: 200, description: "Get a Game item",
        content: new OA\JsonContent(type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Game::class,
                    groups: ["getGame"]
                ))))]
    #[OA\Parameter(name: "id",
        description: "Game ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Tag(name: "Game")]
    public function __invoke(Game $game): JsonResponse
    {
        return $this->getEntityData(
            $game,
            'Game',
            'game',
            'getGame',
            ['game']
        );
    }
}