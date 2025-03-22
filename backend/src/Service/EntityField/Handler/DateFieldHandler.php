<?php

namespace App\Service\EntityField\Handler;

use App\Service\EntityField\FieldErrorHandler;
use App\Service\EntityField\FieldTypeDetector;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class DateFieldHandler extends AbstractFieldHandler
{
    private string $dateFormat = 'd/m/Y';

    public function __construct(
        private readonly FieldTypeDetector $fieldTypeDetector,
        private readonly FieldErrorHandler $errorHandler
    ) {
    }

    public function supports(string $fieldType): bool
    {
        return in_array($fieldType, ['date', 'datetime', 'datetime_immutable']);
    }

    public function isDateField(object $entity, string $fieldName): bool
    {
        return $this->fieldTypeDetector->isDateField($entity, $fieldName);
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

            if ($data[$fieldName] instanceof \DateTimeInterface) {
                $setter = 'set' . ucfirst($fieldName);
                $entity->$setter($data[$fieldName]);
                continue;
            }

            if (!$required && $data[$fieldName] === '') {
                $setter = 'set' . ucfirst($fieldName);
                $entity->$setter(null);
                continue;
            }

            $date = $this->parseDate($data[$fieldName]);

            if ($date) {
                $setter = 'set' . ucfirst($fieldName);
                $entity->$setter($date);
            } else {
                if ($errors) {
                    $this->errorHandler->addError(
                        $entity,
                        $fieldName,
                        'Invalid date format for ' . $fieldName . '. Required format: DD/MM/YYYY',
                        null,
                        $errors
                    );
                }
                $success = false;
            }
        }

        return $success;
    }

    private function parseDate(string $dateString): ?\DateTime
    {
        $date = \DateTime::createFromFormat($this->dateFormat, $dateString);
        if ($date && $date->format($this->dateFormat) === $dateString) {
            return $date;
        }

        return null;
    }
}