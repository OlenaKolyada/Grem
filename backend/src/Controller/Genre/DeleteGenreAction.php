<?php

namespace App\Controller\Genre;

use App\Controller\Abstract\AbstractDeleteEntityAction;
use App\Entity\Genre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

class DeleteGenreAction extends AbstractDeleteEntityAction
{
    public function __construct(
        protected readonly EntityManagerInterface $manager,
        protected readonly TagAwareCacheInterface $cache
    ) {
        parent::__construct($manager, $cache);
    }
    #[Route('/api/genre/{id}', name: 'app_delete_genre', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 204, description: "Genre item successfully deleted")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Response(response: 404, description: "Genre not found")]
    #[OA\Parameter(name: "id", description: "Genre ID", in: "path",
        required: true, schema: new OA\Schema(type: "integer")
    )]
    #[OA\Tag(name: "Genre")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Genre $genre): Response
    {
        return $this->deleteEntity($genre, "genreCache");
    }
}