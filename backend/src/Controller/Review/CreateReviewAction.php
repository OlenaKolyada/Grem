<?php

namespace App\Controller\Review;

use App\Controller\Abstract\AbstractCreateEntityAction;
use App\Entity\Review;
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

class CreateReviewAction extends AbstractCreateEntityAction
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

        $this->fieldConfig = $configFactory->create('review');
    }

    #[Route('/api/review',
        name: 'app_create_review_item',
        requirements: ['_format' => 'json'],
        methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 201, description: "Review item successfully created")]
    #[OA\Response(response: 400, description: "Validation failed - invalid data provided")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\RequestBody(
        description: "Review data",
        required: true,
        content: new OA\MediaType(
            mediaType: "application/json",
            schema: new OA\Schema(
                required: ["title", "status", "content", "summary"],
                properties: [
                    new OA\Property(property: "title", type: "string", example: "Unique Title"),
                    new OA\Property(property: "slug", type: "string", example: ""),
                    new OA\Property(property: "content", type: "string", example: "Minimum 10 characters"),
                    new OA\Property(property: "summary", type: "string", example: "Minimum 10 characters"),
                    new OA\Property(property: "status", type: "string",
                        enum: ["Published", "Draft", "Archived", "Deleted"],
                        example: "Published"),
                    new OA\Property(property: "cover", type: "string", example: "cover.jpg"),
                    new OA\Property(property: "author", type: "string", example: "1"),
                    new OA\Property(property: "gameRating", type: "integer", example: 5),
                    new OA\Property(property: "tag", type: "array",
                        items: new OA\Items(type: "string"), example: ["1", "2"]),
                    new OA\Property(property: "game", type: "array",
                        items: new OA\Items(type: "string"), example: ["1", "2"])
                ])))]
    #[OA\Tag(name: "Review")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Request $request): JsonResponse {

        $content = $request->toArray();
        $review = new Review();

        return $this->createEntityData($review, $content, $this->fieldConfig, 'getReview');
    }
}