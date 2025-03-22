<?php

namespace App\Service\EntityField\Handler;

interface FieldHandlerInterface
{
    /**
     * Проверяет, поддерживает ли обработчик указанный тип поля
     */
    public function supports(string $fieldType): bool;
}