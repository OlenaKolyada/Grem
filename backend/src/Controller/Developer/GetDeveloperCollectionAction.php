<?php

namespace App\Controller\Developer;

use App\Entity\Developer;
use App\Repository\DeveloperRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

readonly class GetDeveloperCollectionAction
{
    public function __construct(
        private DeveloperRepository $repository,
        private CacheService $cacheService
    ) {
    }

    #[Route('/api/developer', name: 'app_get_developer_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Developer collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                type: Developer::class,
                groups: ["getDeveloperCollection"]))))]
    #[OA\Tag(name: "Developer")]
    public function __invoke(): JsonResponse
    {
        $idCache = "getDeveloperCollectionAction";

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "developerCache",
            function() {
                return $this->repository->findAll();
            },
            'getDeveloperCollection',
            ['developer']
        );

        return new JsonResponse(
            $jsonData,
            Response::HTTP_OK,
            [],
            true
        );
    }
}