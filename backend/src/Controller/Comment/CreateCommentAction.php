<?php

namespace App\Controller\Comment;

use App\Controller\Abstract\AbstractEntityController;
use App\Entity\Comment;
use App\Repository\UserRepository;
use App\Repository\ReviewRepository;
use App\Service\EntityField\FieldManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

class CreateCommentAction extends AbstractEntityController
{
    private array $fieldConfig;
    public function __construct(
        protected EntityManagerInterface  $manager,
        protected SerializerInterface     $serializer,
        protected FieldManager            $fieldManager,
        protected ValidatorInterface      $validator,
        private readonly UserRepository   $userRepository,
        private readonly ReviewRepository $reviewRepository,
    ) {
        parent::__construct($manager, $serializer, $validator, $fieldManager);

        $this->fieldConfig = [
            'required' => ['content', 'status'],
            'optional' => ['country', 'website'],
            'relations' => [
                'author' => [
                    'type' => 'entity',
                    'repository' => $this->userRepository,
                    'numericField' => 'id',
                    'stringField' => 'title'
                ],
                'review' => [
                    'type' => 'entity',
                    'repository' => $this->reviewRepository,
                    'numericField' => 'id',
                    'stringField' => 'title'
                ]
            ]
        ];
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
    ): JsonResponse {

        $content = $request->toArray();
        $comment = new Comment();
        $validationErrors = new ConstraintViolationList();

        $this->processFieldsFromConfig($comment, $content, $this->fieldConfig, $validationErrors);

        $errorResponse = $this->processErrors($comment, $validationErrors);
        if ($errorResponse) {
            return $errorResponse;
        }

        $this->manager->persist($comment);
        $this->manager->flush();

        return $this->createSuccessResponse($comment, 'getComment', Response::HTTP_CREATED);
    }
}