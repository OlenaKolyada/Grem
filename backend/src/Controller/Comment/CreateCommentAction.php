<?php

namespace App\Controller\Comment;

use App\Controller\Abstract\AbstractCreateEntityAction;
use App\Entity\Comment;
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

class CreateCommentAction extends AbstractCreateEntityAction
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

        $this->fieldConfig = $configFactory->create('comment');
    }

    #[Route('/api/comment',
        name: 'app_create_comment_item',
        requirements: ['_format' => 'json'],
        methods: ['POST'])]
    #[IsGranted('ROLE_USER', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 201, description: "Comment successfully created")]
    #[OA\Response(response: 400, description: "Validation failed - invalid data provided")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\RequestBody(
        description: "Comment data",
        required: true,
        content: new OA\MediaType(
            mediaType: "application/json",
            schema: new OA\Schema(
                required: ["content", "status", "review"],
                properties: [
                    new OA\Property(property: "content", type: "string", example: "New comment"),
                    new OA\Property(property: "status", type: "string",
                        enum: ["Published", "Edited", "Deleted"],
                        example: 'Published'),
                    new OA\Property(property: "author", type: "string", example: '1'),
                    new OA\Property(property: "review", type: "string", example: '1')
                ])))]
    #[OA\Tag(name: "Comment")]
    #[Security(name: "bearerAuth")]
    public function __invoke(
        Request $request
    ): JsonResponse
    {
        $content = $request->toArray();
        $comment = new Comment();

        return $this->createEntityData($comment, $content, $this->fieldConfig, 'getComment');
    }
}