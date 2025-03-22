<?php

namespace App\Service\EntityField;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class FieldErrorHandler
{
    public function addError(
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