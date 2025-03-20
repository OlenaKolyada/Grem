<?php

namespace App\Controller\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;

readonly class DeleteUserAction
{
    public function __construct(
        private EntityManagerInterface $manager,
        private TagAwareCacheInterface $cache
    ) {
    }
    #[Route('/api/user/{id}', name: 'app_delete_user', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 204, description: "User item successfully deleted")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Response(response: 404, description: "User not found")]
    #[OA\Parameter(name: "id", description: "User ID", in: "path",
        required: true, schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "User")]
    #[Security(name: "bearerAuth")]
    public function __invoke(User $user): Response
    {
        $this->cache->invalidateTags(["userCache"]);
        $this->manager->remove($user);
        $this->manager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}