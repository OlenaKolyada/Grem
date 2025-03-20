<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Service\CacheService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

class GetUserAction extends AbstractController
{
    public function __construct(
        private readonly CacheService $cacheService
    ) {
    }

    #[Route('/api/user/{id}', name: 'app_get_user_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a User item",
        content: new OA\JsonContent(
            ref: new Model(
                type: User::class,
                groups: ["getUser"])))]
    #[OA\Parameter(name: "id",
        description: "User ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "User")]
    public function __invoke(User $user): JsonResponse
    {
        // Проверка авторизации
        if (!$this->getUser()) {
            return new JsonResponse(['error' => 'Not authenticated'], Response::HTTP_UNAUTHORIZED);
        }

        $idCache = "getUserAction-" . $user->getId();

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "userCache",
            function() use ($user) {
                return $user;
            },
            'getUser',
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