<?php

namespace App\Service\EntityField;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class EnumFieldHandler extends AbstractFieldHandler
{
    public function supports(string $fieldType): bool
    {
        return in_array($fieldType, ['enum', 'backedenum']);
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
        // Если поле не обязательное и отсутствует
        if (!$isRequired && empty($data[$fieldName])) {
            return true;
        }

        // Проверяем наличие обязательного поля
        if ($isRequired && empty($data[$fieldName])) {
            if ($errors) {
                $this->addError(
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
                if ($case->name === $valueProvided || $case->value === $valueProvided) {
                    $value = $case;
                    break;
                }
            }

            if ($value === null) {
                if ($errors) {
                    $validValues = array_map(function($case) {
                        return $case->name;
                    }, $cases);

                    $this->addError(
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
                $this->addError(
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