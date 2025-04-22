<?php

namespace App\Controller\Auth;

use App\Entity\User;
use App\Service\TokenManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class LoginAction extends AbstractController
{
    public function __construct(
        private readonly TokenManager $tokenManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface $entityManager
    ) {}

    #[OA\Post(
        path: "/login",
        description: "Send credentials to log in and receive a session cookie",
        summary: "Login to get authentication cookie",
        tags: ["Auth"]
    )]
    #[OA\RequestBody(
        description: "User credentials",
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "email", type: "string", example: "brie@gmail.com"),
                new OA\Property(property: "password", type: "string", example: "password")
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Login successful (sets session_id cookie)",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "message", type: "string", example: "Login successful")
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: "Missing credentials",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "error", type: "string", example: "Missing credentials")
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Invalid credentials",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "error", type: "string", example: "Invalid credentials")
            ]
        )
    )]
    #[Route('/login', name: 'login', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // Валидация данных
        if (!isset($data['email']) || !isset($data['password'])) {
            return new JsonResponse(['error' => 'Missing credentials'], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $data['email']]);

        // Проверка пароля
        if (!$user || !$this->passwordHasher->isPasswordValid($user, $data['password'])) {
            return new JsonResponse(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }

        // Создание токена
        $userToken = $this->tokenManager->createToken($user);

        // Создание ответа с сессионным id в куки и в теле для тестирования
        $response = new JsonResponse([
            'message' => 'Login successful',
            'session_id' => $userToken->getSessionId() // добавляем для упрощения тестирования
        ]);

        $response->headers->setCookie(new Cookie(
            'session_id',          // Имя куки
            $userToken->getSessionId(), // Значение (sessionId, не сам JWT)
            $userToken->getExpiresAt()->getTimestamp(), // Время истечения
            '/',                   // Путь
            null,                  // Домен
            false,                 // Только HTTPS (false для HTTP localhost)
            true,                  // HttpOnly
            false,                 // Raw
            Cookie::SAMESITE_LAX   // LAX для работы между портами
        ));

        return $response;
    }
}