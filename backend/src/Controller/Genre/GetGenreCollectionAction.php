<?php

namespace App\Controller\Genre;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

readonly class GetGenreCollectionAction
{
    public function __construct(
        private GenreRepository $repository,
        private CacheService $cacheService
    ) {
    }
    #[Route('/api/genre', name: 'app_get_genre_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Genre collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Genre::class,
                    groups: ["getGenreCollection"]))))]
    #[OA\Tag(name: "Genre")]
    public function __invoke(): JsonResponse
    {
        $idCache = "getGenreCollectionAction";

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "genreCache",
            function() {
                return $this->repository->findAll();
            },
            'getGenreCollection',
            ['genre']
        );

        return new JsonResponse(
            $jsonData,
            Response::HTTP_OK,
            [],
            true
        );
    }
}