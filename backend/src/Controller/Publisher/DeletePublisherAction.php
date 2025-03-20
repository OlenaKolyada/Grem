<?php

namespace App\Controller\Publisher;

use App\Entity\Publisher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;

readonly class DeletePublisherAction
{
    public function __construct(
        private EntityManagerInterface $manager,
        private TagAwareCacheInterface $cache
    ) {
    }
    #[Route('/api/publisher/{id}', name: 'app_delete_publisher', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 204, description: "Publisher item successfully deleted")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Response(response: 404, description: "Publisher not found")]
    #[OA\Parameter(name: "id", description: "Publisher ID", in: "path",
        required: true, schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "Publisher")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Publisher $publisher): Response
    {
        $this->cache->invalidateTags(["publisherCache"]);
        $this->manager->remove($publisher);
        $this->manager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}