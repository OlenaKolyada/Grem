<?php

namespace App\Controller\Developer;

use App\Controller\Abstract\AbstractCreateEntityAction;
use App\Entity\Developer;
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

class CreateDeveloperAction extends AbstractCreateEntityAction
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

        $this->fieldConfig = $configFactory->create('developer');
    }

    #[Route('/api/developer', name: 'app_create_developer', requirements: ['_format' => 'json'], methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 201, description: "Developer item successfully created")]
    #[OA\Response(response: 400, description: "Validation failed - invalid data provided")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\RequestBody(
        description: "Developer data",
        required: true, content: new OA\MediaType(
        mediaType: "application/json",
        schema: new OA\Schema(required: ["title"],
            properties: [
                new OA\Property(property: "title", type: "string", example: "Unique Developer"),
                new OA\Property(property: "slug", type: "string", example: ""),
                new OA\Property(property: "country", type: "string", example: "Spain"),
                new OA\Property(property: "website", type: "string", example: "https://example.com"),
                new OA\Property(property: "game", type: "array",
                    items: new OA\Items(type: "string"), example: ["1", "2"])
            ])))]
    #[OA\Tag(name: "Developer")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Request $request): JsonResponse
    {
        $content = $request->toArray();
        $developer = new Developer();

        return $this->createEntityData($developer, $content, $this->fieldConfig, 'getDeveloper');
    }
}