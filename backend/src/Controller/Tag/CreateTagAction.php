<?php

namespace App\Controller\Tag;

use App\Controller\Abstract\AbstractCreateEntityAction;
use App\Entity\Tag;
use App\Service\EntityField\Configuration\EntityConfigurationFactoryInterface;
use App\Service\EntityField\Processor\ErrorProcessor;
use App\Service\EntityField\Processor\FieldProcessor;
use App\Service\EntityField\Processor\ResponseProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

class CreateTagAction extends AbstractCreateEntityAction
{
    private array $fieldConfig;

    public function __construct(
        EntityManagerInterface $manager,
        FieldProcessor $fieldProcessor,
        ErrorProcessor $errorProcessor,
        ResponseProcessor $responseProcessor,
        EntityConfigurationFactoryInterface $configFactory
    ) {
        parent::__construct($manager, $fieldProcessor, $errorProcessor, $responseProcessor);

        $this->fieldConfig = $configFactory->create('tag');
    }

    #[Route('/api/tag', name: 'app_create_tag', requirements: ['_format' => 'json'], methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 201, description: "Tag item successfully created")]
    #[OA\Response(response: 400, description: "Validation failed - invalid data provided")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\RequestBody(
        description: "Tag data",
        required: true, content: new OA\MediaType(
        mediaType: "application/json",
        schema: new OA\Schema(required: ["title"],
            properties: [
                new OA\Property(property: "title", type: "string", example: "UniqueTitle"),
                new OA\Property(property: "slug", type: "string", example: ""),
                new OA\Property(property: "news", type: "array",
                    items: new OA\Items(type: "string"), example: ["1", "2"]),
                new OA\Property(property: "review", type: "array",
                    items: new OA\Items(type: "string"), example: ["1", "2"])
            ])))]
    #[OA\Tag(name: "Tag")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Request $request): JsonResponse
    {
        $content = $request->toArray();
        $tag = new Tag();

        return $this->createEntityData($tag, $content, $this->fieldConfig, 'getTag');
    }
}