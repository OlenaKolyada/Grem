<?php

namespace App\Service\EntityField;

use App\Service\EntityField\Handler\FieldHandlerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class AbstractFieldHandler implements FieldHandlerInterface
{
    /**
     * Добавляет ошибку валидации к списку ошибок
     */
    protected function addError(
        object $entity,
        string $fieldName,
        string $message,
               $invalidValue,
        ConstraintViolationListInterface $errors
    ): void {
        $errors->add(
            new ConstraintViolation(
                $message,
                null,
                [],
                $entity,
                $fieldName,
                $invalidValue
            )
        );
    }
}