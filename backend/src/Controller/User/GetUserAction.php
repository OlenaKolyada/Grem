<?php

namespace App\Controller\User;

use App\Controller\Abstract\AbstractGetEntityAction;
use App\Entity\User;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\SecurityBundle\Security;

class GetUserAction extends AbstractGetEntityAction
{
    private readonly Security $security;

    public function __construct(
        CacheService $cacheService,
        Security $security
    ) {
        parent::__construct($cacheService);
        $this->security = $security;
    }

    #[Route('/api/user/{id}', name: 'app_get_user_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a User item",
        content: new OA\JsonContent(
            ref: new Model(
                type: User::class,
                groups: ["getUser"]
            )))]
    #[OA\Parameter(name: "id",
        description: "User ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Tag(name: "User")]
    public function __invoke(User $user): JsonResponse
    {
        if (!$this->security->getUser()) {
            return new JsonResponse(['error' => 'Not authenticated'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->getEntityData(
            $user,
            'User',
            'user',
            'getUser',
            ['user']
        );
    }
}