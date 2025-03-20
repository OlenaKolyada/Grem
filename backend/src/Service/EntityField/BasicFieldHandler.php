<?php

namespace App\Service\EntityField;

use ReflectionClass;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class BasicFieldHandler extends AbstractFieldHandler
{
    private EnumFieldHandler $enumFieldHandler;

    public function __construct(EnumFieldHandler $enumFieldHandler)
    {
        $this->enumFieldHandler = $enumFieldHandler;
    }

    public function supports(string $fieldType): bool
    {
        return in_array($fieldType, ['string', 'text', 'basic']);
    }

    /**
     * Обрабатывает поля
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
            // Проверка для обязательных полей
            if ($required && empty($data[$fieldName])) {
                if ($errors) {
                    $this->addError(
                        $entity,
                        $fieldName,
                        $errorMessage ?? ucfirst($fieldName) . ' is required',
                        null,
                        $errors
                    );
                }
                $success = false;
                continue;
            }

            // Пропускаем необязательные поля, если их нет в данных
            if (!$required && !isset($data[$fieldName])) {
                continue;
            }

            // Проверяем, является ли поле Enum через рефлексию
            $enumClass = $this->getFieldEnumType($entity, $fieldName);

            if ($enumClass) {
                // Если это Enum, обрабатываем через EnumFieldHandler
                $this->enumFieldHandler->handleEnumField(
                    $entity,
                    $data,
                    $fieldName,
                    $enumClass,
                    $errors,
                    $required,
                    $errorMessage
                );
            } else {
                // Иначе устанавливаем как обычное поле
                $setter = 'set' . ucfirst($fieldName);
                $entity->$setter($data[$fieldName]);
            }
        }

        return $success;
    }

    /**
     * Определяет тип Enum для поля сущности
     */
    private function getFieldEnumType(object $entity, string $fieldName): ?string
    {
        try {
            $reflection = new ReflectionClass($entity);

            if (!$reflection->hasProperty($fieldName)) {
                return null;
            }

            $property = $reflection->getProperty($fieldName);
            $type = $property->getType();

            if ($type && !$type->isBuiltin()) {
                $typeName = $type->getName();

                // Проверяем, является ли тип Enum
                if (enum_exists($typeName)) {
                    return $typeName;
                }
            }
        } catch (\Exception $e) {
            // В случае ошибки просто возвращаем null
        }

        return null;
    }
}