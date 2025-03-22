<?php

namespace App\Service\EntityField\Handler;

use App\Service\EntityField\FieldErrorHandler;
use App\Service\EntityField\FieldTypeDetector;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class EnumFieldHandler extends AbstractFieldHandler
{
    public function __construct(
        private readonly FieldTypeDetector $fieldTypeDetector,
        private readonly FieldErrorHandler $errorHandler
    ) {
    }

    public function supports(string $fieldType): bool
    {
        return in_array($fieldType, ['enum', 'backedenum']);
    }

    /**
     * Обрабатывает поля с enum значениями
     */
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
            $enumClass = $this->fieldTypeDetector->isEnumField($entity, $fieldName);

            if (!$enumClass) {
                continue; // Пропускаем не-enum поля
            }

            // Проверяем, есть ли поле в данных
            if (!array_key_exists($fieldName, $data)) {
                if ($required) {
                    // Если поле обязательное, но его нет в данных - ошибка
                    if ($errors) {
                        $this->errorHandler->addError(
                            $entity,
                            $fieldName,
                            $errorMessage ?? ucfirst($fieldName) . ' is required',
                            null,
                            $errors
                        );
                    }
                    $success = false;
                }
                continue;
            }

            $fieldSuccess = $this->handleEnumField(
                $entity,
                $data,
                $fieldName,
                $enumClass,
                $errors,
                $required,
                $errorMessage
            );

            if (!$fieldSuccess) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Обрабатывает поле с enum значением
     */
    public function handleEnumField(
        object $entity,
        array $data,
        string $fieldName,
        string $enumClass,
        ?ConstraintViolationListInterface $errors = null,
        bool $isRequired = true,
        ?string $errorMessage = null
    ): bool {
        // Если поле не обязательное и отсутствует или пустое
        if (!$isRequired && (empty($data[$fieldName]) || !isset($data[$fieldName]))) {
            return true;
        }

        // Проверяем наличие обязательного поля
        if ($isRequired && (empty($data[$fieldName]) || !isset($data[$fieldName]))) {
            if ($errors) {
                $this->errorHandler->addError(
                    $entity,
                    $fieldName,
                    $errorMessage ?? ucfirst($fieldName) . ' is required',
                    null,
                    $errors
                );
            }
            return false;
        }

        try {
            // Безопасное получение значения Enum с помощью рефлексии
            $valueProvided = $data[$fieldName];
            $value = null;

            // Проверяем все кейсы Enum и находим соответствующий
            $reflectionClass = new \ReflectionClass($enumClass);
            $cases = $reflectionClass->getMethod('cases')->invoke(null);

            foreach ($cases as $case) {
                if ((string)$case->name === (string)$valueProvided ||
                    (property_exists($case, 'value') && (string)$case->value === (string)$valueProvided)) {
                    $value = $case;
                    break;
                }
            }

            if ($value === null) {
                if ($errors) {
                    $validValues = array_map(function($case) {
                        return $case->name;
                    }, $cases);

                    $this->errorHandler->addError(
                        $entity,
                        $fieldName,
                        $errorMessage ?? sprintf(
                        'Invalid %s value provided. Valid values: %s',
                        $fieldName,
                        implode(', ', $validValues)
                    ),
                        $valueProvided,
                        $errors
                    );
                }
                return false;
            }

            // Устанавливаем значение
            $setter = 'set' . ucfirst($fieldName);
            $entity->$setter($value);
            return true;
        } catch (\Exception $e) {
            if ($errors) {
                $this->errorHandler->addError(
                    $entity,
                    $fieldName,
                    "Error processing enum: " . $e->getMessage(),
                    null,
                    $errors
                );
            }
            return false;
        }
    }
}