<?php

namespace App\Controller\User;

use App\Controller\Abstract\AbstractEntityController;
use App\Entity\User;
use App\Repository\NewsRepository;
use App\Repository\ReviewRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\EntityField\EntityFieldManager;
use App\Service\User\UserEmailService;
use App\Service\User\UserPasswordService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;

class CreateUserAction extends AbstractEntityController
{
    private array $fieldConfig;

    public function __construct(
        protected EntityManagerInterface $manager,
        protected SerializerInterface $serializer,
        protected EntityFieldManager $fieldManager,
        protected ValidatorInterface $validator,
        private readonly NewsRepository $newsRepository,
        private readonly ReviewRepository $reviewRepository,
        private readonly CommentRepository $commentRepository,
        private readonly UserEmailService $userEmailService,
        private readonly UserPasswordService $userPasswordService
    ) {
        parent::__construct($manager, $serializer, $validator, $fieldManager);

        $this->fieldConfig = [
            'required' => ['nickname', 'email', 'password', 'roles'],
            'optional' => ['avatar', 'twitchAccount'],
            'relations' => [
                'news' => [
                    'type' => 'collection',
                    'repository' => $this->newsRepository,
                    'numericField' => 'id',
                    'stringField' => 'title'
                ],
                'review' => [
                    'type' => 'collection',
                    'repository' => $this->reviewRepository,
                    'numericField' => 'id',
                    'stringField' => 'title'
                ],
                'comment' => [
                    'type' => 'collection',
                    'repository' => $this->commentRepository,
                    'numericField' => 'id',
                    'stringField' => 'content'
                ],
            ]
        ];
    }

    #[Route('/api/user', name: 'app_create_user', requirements: ['_format' => 'json'], methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 201, description: "User item successfully created")]
    #[OA\Response(response: 400, description: "Validation failed - invalid data provided")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\RequestBody(
        description: "User data",
        required: true,
        content: new OA\MediaType(
            mediaType: "application/json",
            schema: new OA\Schema(
                required: ["nickname", "email", "password", "roles"],
                properties: [
                    new OA\Property(property: "nickname", type: "string", example: "Must be unique"),
                    new OA\Property(property: "email", type: "string", example: "must_be_unique@gmail.com"),
                    new OA\Property(property: "password", type: "string", example: "password"),
                    new OA\Property(property: "roles", type: "array",
                        items: new OA\Items(type: "string"), example: ["ROLE_USER"]),
                    new OA\Property(property: "twitchAccount", type: "string", example: "https://twitch.com/user"),
                    new OA\Property(property: "avatar", type: "string", example: "avatar.jpg"),
                    new OA\Property(property: "news", type: "array",
                        items: new OA\Items(type: "string"), example: ["ID1", "ID2"]),
                    new OA\Property(property: "review", type: "array",
                        items: new OA\Items(type: "string"), example: ["ID1", "ID2"]),
                    new OA\Property(property: "comment", type: "array",
                        items: new OA\Items(type: "string"), example: ["ID1", "ID2"])
                ])))]

    #[OA\Tag(name: "User")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Request $request): JsonResponse
    {
        $content = $request->toArray();
        $user = new User();
        $validationErrors = new ConstraintViolationList();

        $emailError = $this->userEmailService->checkUniqueEmail($content['email'] ?? '');
        if ($emailError) {
            return $emailError;
        }

        $this->processFieldsFromConfig($user, $content, $this->fieldConfig, $validationErrors);

        $this->userPasswordService->hashPasswordIfNeeded($user, $content['password'] ?? null);

        $errorResponse = $this->processErrors($user, $validationErrors);
        if ($errorResponse) {
            return $errorResponse;
        }

        $this->manager->persist($user);
        $this->manager->flush();

        return $this->createSuccessResponse($user, 'getUser', Response::HTTP_CREATED);
    }
}
