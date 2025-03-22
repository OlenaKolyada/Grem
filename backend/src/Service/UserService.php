<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserService
{
    public function __construct(
        private EntityManagerInterface      $manager,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    /**
     * 🔹 Хеширует пароль, если он передан
     */
    public function hashPasswordIfNeeded(User $user, ?string $password): void
    {
        if (!empty($password)) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);
        }
    }

    /**
     * 🔹 Проверяет уникальность email и обновляет его, если передан
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


    public function checkUniqueEmail(string $email): ?JsonResponse
    {
        if ($this->manager->getRepository(User::class)->findOneBy(['email' => $email])) {
            return new JsonResponse(['message' => 'Email already exists.'], Response::HTTP_BAD_REQUEST);
        }

        return null;
    }

}
