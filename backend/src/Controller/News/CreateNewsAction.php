<?php

namespace App\Controller\News;

use App\Controller\Abstract\AbstractCreateEntityAction;
use App\Entity\News;
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

class CreateNewsAction extends AbstractCreateEntityAction
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

        $this->fieldConfig = $configFactory->create('news');
    }

    #[Route('/api/news', name: 'app_create_news_item', requirements: ['_format' => 'json'], methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 201, description: "News item successfully created")]
    #[OA\Response(response: 400, description: "Validation failed - invalid data provided")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\RequestBody(
        description: "News data",
        required: true,
        content: new OA\MediaType(
            mediaType: "application/json",
            schema: new OA\Schema(
                required: ["title", "content", "summary", "status"],
                properties: [
                    new OA\Property(property: "title", type: "string", example: "Unique Title"),
                    new OA\Property(property: "slug", type: "string", example: ""),
                    new OA\Property(property: "content", type: "string", example: "Minimum 10 characters"),
                    new OA\Property(property: "summary", type: "string", example: "Minimum 10 characters"),
                    new OA\Property(property: "status", type: "string",
                        enum: ["Published", "Draft", "Archived", "Deleted"], example: "Published"),
                    new OA\Property(property: "cover", type: "string", example: "cover.jpg"),
                    new OA\Property(property: "author", type: "string", example: "1"),
                    new OA\Property(property: "tag", type: "array",
                        items: new OA\Items(type: "string"), example: ["1", "2"]),
                    new OA\Property(property: "game", type: "array",
                        items: new OA\Items(type: "string"), example: ["1", "2"])
                    ])))]
    #[OA\Tag(name: "News")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Request $request): JsonResponse {

        $content = $request->toArray();
        $news = new News();

        return $this->createEntityData($news, $content, $this->fieldConfig, 'getNews');
    }
}