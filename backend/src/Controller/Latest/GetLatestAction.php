<?php

namespace App\Controller\Latest;

use App\Service\CacheService;
use App\Service\RepositoryRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

readonly class GetLatestAction
{
    public function __construct(
        private RepositoryRegistry $repositoryRegistry,
        private CacheService $cacheService
    ) {
    }

    #[Route('/api/latest',
        name: 'app_get_latest',
        methods: ['GET']
    )]
    #[OA\Response(
        response: 200,
        description: "Get latest items for specified categories",
        content: new OA\JsonContent(type: "object")
    )]
    #[OA\Parameter(
        name: "categories",
        description: "Comma-separated list of categories",
        in: "query",
        required: true,
        schema: new OA\Schema(type: "string")
    )]
    #[OA\Tag(name: "Latest")]
    public function __invoke(Request $request): JsonResponse
    {
        $categoriesParam = $request->query->get('categories', '');
        $categories = array_filter(explode(',', $categoriesParam));

        if (empty($categories)) {
            return new JsonResponse(['error' => 'No categories specified'], Response::HTTP_BAD_REQUEST);
        }

        $result = [];

        foreach ($categories as $category) {
            $repository = $this->repositoryRegistry->getRepositoryForCategory($category);

            if (!$repository) {
                continue;
            }

            $idCache = "getLatestAction-" . $category;
            $latestItem = $repository->findLatest();

            if ($latestItem) {
                $serializationGroup = 'get' . ucfirst($category);
                $cacheType = $category . 'Cache';

                $jsonItem = $this->cacheService->getCachedData(
                    $idCache,
                    $cacheType,
                    function() use ($latestItem) {
                        return $latestItem;
                    },
                    $serializationGroup,
                    [$category]
                );

                $itemArray = json_decode($jsonItem, true);
                $itemArray['_categoryName'] = $category;
                $result[$category] = $itemArray;
            }
        }

        return new JsonResponse(
            json_encode($result),
            Response::HTTP_OK,
            [],
            true
        );
    }
}