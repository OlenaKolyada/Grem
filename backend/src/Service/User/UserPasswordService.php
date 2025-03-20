<?php

namespace App\Service\User;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserPasswordService
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    /**
     * Хеширует пароль, если он передан
     */
    public function hashPasswordIfNeeded(User $user, ?string $password): void
    {
        if (!empty($password)) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);
        }
    }
}