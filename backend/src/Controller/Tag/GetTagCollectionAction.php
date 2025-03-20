<?php

namespace App\Controller\Tag;

use App\Entity\Tag;
use App\Repository\TagRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

readonly class GetTagCollectionAction
{
    public function __construct(
        private TagRepository $repository,
        private CacheService $cacheService
    ) {
    }
    #[Route('/api/tag', name: 'app_get_tag_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Tag collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Tag::class,
                    groups: ["getTagCollection"]))))]
    #[OA\Tag(name: "Tag")]
    public function __invoke(): JsonResponse
    {
        $idCache = "getTagCollectionAction";

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "tagCache",
            function() {
                return $this->repository->findAll();
            },
            'getTagCollection',
            ['tag']
        );

        return new JsonResponse(
            $jsonData,
            Response::HTTP_OK,
            [],
            true
        );
    }
}