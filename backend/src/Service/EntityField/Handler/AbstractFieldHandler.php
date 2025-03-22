<?php

namespace App\Service\EntityField\Handler;

use App\Service\EntityField\FieldErrorHandler;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class AbstractFieldHandler
{
    abstract public function supports(string $fieldType): bool;

    protected function validateRequiredField(
        object $entity,
        array $data,
        string $fieldName,
        FieldErrorHandler $errorHandler,
        ?ConstraintViolationListInterface $errors,
        bool $required,
        ?string $errorMessage = null
    ): bool {

        if ($required && !isset($data[$fieldName])) {
            if ($errors) {
                $errorHandler->addError(
                    $entity,
                    $fieldName,
                    $errorMessage ?? ucfirst($fieldName) . ' is required',
                    null,
                    $errors
                );
            }
            return false;
        }

        if (!$required && !isset($data[$fieldName])) {
            return false;
        }

        return true;
    }
}