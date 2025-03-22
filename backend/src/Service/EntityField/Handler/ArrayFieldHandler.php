<?php

namespace App\Service\EntityField\Handler;

use App\Service\EntityField\FieldErrorHandler;
use App\Service\EntityField\FieldTypeDetector;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ArrayFieldHandler extends AbstractFieldHandler
{
    public function __construct(
        private readonly FieldTypeDetector $fieldTypeDetector,
        private readonly FieldErrorHandler $errorHandler
    ) {
    }

    public function supports(string $fieldType): bool
    {
        return in_array($fieldType, ['array', 'collection']);
    }

    public function isArrayField(object $entity, string $fieldName): bool
    {
        return $this->fieldTypeDetector->isArrayField($entity, $fieldName);
    }

    public function handleFields(
        object $entity,
        array $data,
        array $fieldNames,
        ?ConstraintViolationListInterface $errors = null,
        bool $required = false,
        ?string $errorMessage = null
    ): bool {
        $success = true;

        foreach ($fieldNames as $fieldName) {

            $fieldValid = $this->validateRequiredField(
                $entity,
                $data,
                $fieldName,
                $this->errorHandler,
                $errors,
                $required,
                $errorMessage
            );

            if (!$fieldValid) {
                $success = false;
                continue;
            }

            $value = $data[$fieldName];

            if (!is_array($value)) {
                if ($errors) {
                    $this->errorHandler->addError(
                        $entity,
                        $fieldName,
                        $errorMessage ?? ucfirst($fieldName) . ' must be an array',
                        $value,
                        $errors
                    );
                }
                $success = false;
                continue;
            }

            $adder = 'add' . ucfirst($fieldName);
            $setter = 'set' . ucfirst($fieldName);
            $getter = 'get' . ucfirst($fieldName);
            $remover = 'remove' . ucfirst($fieldName);

            if (method_exists($entity, $setter)) {
                $entity->$setter($value);
                continue;
            }

            if (method_exists($entity, $adder)) {

                if (method_exists($entity, $getter) && method_exists($entity, $remover)) {
                    $collection = $entity->$getter();

                    $itemsToRemove = [];
                    if ($collection !== null) {
                        foreach ($collection as $item) {
                            $itemsToRemove[] = $item;
                        }

                        foreach ($itemsToRemove as $item) {
                            $entity->$remover($item);
                        }
                    }
                }

                foreach ($value as $item) {
                    if ($item !== null) {
                        $entity->$adder($item);
                    }
                }
            } else {
                if ($errors) {
                    $this->errorHandler->addError(
                        $entity,
                        $fieldName,
                        "Cannot handle array field: no suitable setter or adder method found",
                        null,
                        $errors
                    );
                }
                $success = false;
            }
        }

        return $success;
    }
}