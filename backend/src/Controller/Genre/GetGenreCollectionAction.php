<?php

namespace App\Controller\Genre;

use App\Controller\Abstract\AbstractGetMetaEntityCollectionAction;
use App\Entity\Genre;
use App\Repository\GenreRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetGenreCollectionAction extends AbstractGetMetaEntityCollectionAction
{
    public function __construct(
        GenreRepository $repository,
        CacheService $cacheService
    ) {
        parent::__construct($repository, $cacheService);
    }
    #[Route('/api/genre', name: 'app_get_genre_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Genre collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Genre::class,
                    groups: ["getGenreCollection"]
                ))))]
    #[OA\Tag(name: "Genre")]
    public function __invoke(): JsonResponse
    {
        return $this->getEntityData(
            'Genre',
            'genre',
            'getGenreCollection',
            ['genre']
        );
    }
}