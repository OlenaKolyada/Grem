<?php

namespace App\Controller\Genre;

use App\Controller\Abstract\AbstractGetEntityAction;
use App\Entity\Genre;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetGenreAction extends AbstractGetEntityAction
{
    public function __construct(
        protected readonly CacheService $cacheService
    ) {
        parent::__construct($cacheService);
    }

    #[Route('/api/genre/{id}', name: 'app_get_genre_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Genre item",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Genre::class,
                    groups: ["getGenre"]
                ))))]
    #[OA\Parameter(name: "id",
        description: "Genre ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Tag(name: "Genre")]
    public function __invoke(Genre $genre): JsonResponse
    {
        return $this->getEntityData(
            $genre,
            'Genre',
            'genre',
            'getGenre',
            ['genre']
        );
    }
}