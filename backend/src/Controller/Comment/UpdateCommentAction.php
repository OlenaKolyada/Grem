<?php

namespace App\Controller\Comment;

use App\Controller\Abstract\AbstractEntityController;
use App\Entity\Comment;
use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
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

class UpdateCommentAction extends AbstractEntityController
{
    private array $fieldConfig;
    public function __construct(
        protected EntityManagerInterface  $manager,
        protected FieldManager            $fieldManager,
        protected SerializerInterface     $serializer,
        protected ValidatorInterface      $validator,
        private readonly ReviewRepository $reviewRepository,
        private readonly UserRepository   $userRepository,
    ) {
        parent::__construct($manager, $serializer, $validator, $fieldManager);

        $this->fieldConfig = [
            'optional' => ['content', 'status', 'country', 'website'],
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

    #[Route('/api/comment/{id}',
        name: 'app_update_comment_item',
        requirements: ['_format' => 'json'],
        methods: ['PATCH'])]
    #[IsGranted('ROLE_USER', message: 'You do not have sufficient permissions')]
    #[OA\Parameter(name: "id",
        description: "Comment ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer"))]
    #[OA\Response(response: 200, description: "Comment item successfully updated")]
    #[OA\Response(response: 400, description: "Validation failed - invalid data provided")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Response(response: 404, description: "Comment not found")]
    #[OA\RequestBody(
        description: "Comment data",
        required: true,
        content: new OA\MediaType(
            mediaType: "application/json",
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: "content", type: "string"),
                    new OA\Property(property: "status", type: "string",
                        enum: ["Published", "Edited", "Deleted"],
                        example: 'Published'),
                    new OA\Property(property: "author", type: "string", example: 'ID'),
                    new OA\Property(property: "review", type: "string", example: 'ID')
                ])))]
    #[OA\Tag(name: "Comment")]
    #[Security(name: "bearerAuth")]
    public function __invoke(
        Request $request,
        Comment $comment
    ): JsonResponse
    {
        $content = $request->toArray();

        $validationErrors = new ConstraintViolationList();

        $this->processFieldsFromConfig($comment, $content, $this->fieldConfig, $validationErrors);

        $errorResponse = $this->processErrors($comment, $validationErrors);
        if ($errorResponse) {
            return $errorResponse;
        }

        $this->manager->persist($comment);
        $this->manager->flush();

        return $this->createSuccessResponse($comment, 'getComment', Response::HTTP_OK);
    }
}