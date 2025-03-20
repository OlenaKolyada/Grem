<?php

namespace App\Service\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class UserEmailService
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {}

    /**
     * Проверяет уникальность email и обновляет его, если передан
     */
    public function updateEmailIfNeeded(User $user, ?string $email): ?JsonResponse
    {
        if ($email === null || $user->getEmail() === $email) {
            return null;
        }

        $existingUser = $this->manager->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($existingUser) {
            return new JsonResponse(['message' => 'Email already exists.'], Response::HTTP_BAD_REQUEST);
        }

        $user->setEmail($email);
        return null;
    }

    /**
     * Проверяет уникальность email
     */
    public function checkUniqueEmail(string $email): ?JsonResponse
    {
        if ($this->manager->getRepository(User::class)->findOneBy(['email' => $email])) {
            return new JsonResponse(['message' => 'Email already exists.'], Response::HTTP_BAD_REQUEST);
        }

        return null;
    }
}