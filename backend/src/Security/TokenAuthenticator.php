<?php

namespace App\Security;

use App\Service\TokenManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class TokenAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    public function __construct(
        private readonly TokenManager $tokenManager
    ) {}

    public function supports(Request $request): ?bool
    {
        // Применяем аутентификатор только если есть сессионная кука
        return $request->cookies->has('session_id');
    }

    public function authenticate(Request $request): Passport
    {
        $sessionId = $request->cookies->get('session_id');

        if (!$sessionId) {
            throw new AuthenticationException('No session id found');
        }

        // Валидируем токен
        $userToken = $this->tokenManager->validateToken($sessionId);

        if (!$userToken) {
            throw new AuthenticationException('Invalid session');
        }

        // Создаем паспорт с идентификатором пользователя
        return new SelfValidatingPassport(
            new UserBadge($userToken->getUser()->getUserIdentifier())
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Если аутентификация успешна, просто продолжаем запрос
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $response = new JsonResponse(
            ['error' => 'Authentication failed: ' . $exception->getMessage()],
            Response::HTTP_UNAUTHORIZED
        );

        $response->headers->clearCookie('session_id', '/', null);

        return $response;
    }


    // Реализация интерфейса AuthenticationEntryPointInterface
    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new JsonResponse(['error' => 'Authentication required'], Response::HTTP_UNAUTHORIZED);
    }
}