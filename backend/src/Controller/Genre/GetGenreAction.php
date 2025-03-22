<?php

namespace App\Controller\Genre;

use App\Entity\Genre;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

readonly class GetGenreAction
{
    public function __construct(
        private CacheService $cacheService
    ) {
    }

    #[Route('/api/genre/{id}', name: 'app_get_genre_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Genre item",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Genre::class,
                    groups: ["getGenre"]))))]
    #[OA\Parameter(name: "id",
        description: "Genre ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "Genre")]
    public function __invoke(Genre $genre): JsonResponse
    {
        $idCache = "getGenreAction-" . $genre->getId();

        $jsonGenre = $this->cacheService->getCachedData(
            $idCache,
            "genreCache",
            function() use ($genre) {
                return $genre;
            },
            'getGenre',
            ['genre']
        );

        return new JsonResponse(
            $jsonGenre,
            Response::HTTP_OK,
            [],
            true
        );
    }
}