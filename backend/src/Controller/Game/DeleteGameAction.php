<?php

namespace App\Controller\Game;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;

readonly class DeleteGameAction
{
    public function __construct(
        private EntityManagerInterface $manager,
        private TagAwareCacheInterface $cache
    ) {
    }

    #[Route('/api/game/{id}', name: 'app_delete_game_item', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 204, description: "Game item successfully deleted")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Response(response: 404, description: "Game not found")]
    #[OA\Parameter(name: "id", description: "Game ID", in: "path",
        required: true, schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "Game")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Game $game): Response
    {
        $this->cache->invalidateTags(["gameCache"]);
        $this->manager->remove($game);
        $this->manager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}