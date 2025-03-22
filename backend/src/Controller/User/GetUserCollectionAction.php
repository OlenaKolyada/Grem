<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

readonly class GetUserCollectionAction
{
    public function __construct(
        private UserRepository $repository,
        private CacheService $cacheService
    ) {
    }
    #[Route('/api/user', name: 'app_get_user_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a User collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                type: User::class,
                groups: ["getUserCollection"]))))]
    #[OA\Tag(name: "User")]
    public function __invoke(): JsonResponse
    {
        $idCache = "getUserCollectionAction";

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "userCache",
            function() {
                return $this->repository->findAll();
            },
            'getUserCollection',
            ['user']
        );

        return new JsonResponse(
            $jsonData,
            Response::HTTP_OK,
            [],
            true
        );
    }
}