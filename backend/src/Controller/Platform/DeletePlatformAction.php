<?php

namespace App\Controller\Platform;

use App\Entity\Platform;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

readonly class DeletePlatformAction
{
    public function __construct(
        private EntityManagerInterface $manager,
        private TagAwareCacheInterface $cache
    ) {
    }
    #[Route('/api/platform/{id}', name: 'app_delete_platform', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 204, description: "Platform item successfully deleted")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Response(response: 404, description: "Platform not found")]
    #[OA\Parameter(name: "id", description: "Platform ID", in: "path",
        required: true, schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "Platform")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Platform $platform): Response
    {
        $this->cache->invalidateTags(["platformCache"]);
        $this->manager->remove($platform);
        $this->manager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}