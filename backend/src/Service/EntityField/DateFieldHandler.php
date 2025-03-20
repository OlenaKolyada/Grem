<?php

namespace App\Service\EntityField;

use ReflectionClass;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class DateFieldHandler extends AbstractFieldHandler
{
    /**
     * Поддерживаемые форматы дат
     */
    private array $supportedFormats = [
        'd/m/Y',      // 01/01/2023
        'Y-m-d',      // 2023-01-01
        'd.m.Y',      // 01.01.2023
        'd-m-Y',      // 01-01-2023
    ];

    public function supports(string $fieldType): bool
    {
        return in_array($fieldType, ['date', 'datetime', 'datetime_immutable']);
    }

    /**
     * Обрабатывает поля типа дата
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

            // Если значение уже является объектом DateTime, используем его напрямую
            if ($data[$fieldName] instanceof \DateTimeInterface) {
                $setter = 'set' . ucfirst($fieldName);
                $entity->$setter($data[$fieldName]);
                continue;
            }

            // Если значение пустое для необязательного поля, устанавливаем null
            if (!$required && $data[$fieldName] === '') {
                $setter = 'set' . ucfirst($fieldName);
                $entity->$setter(null);
                continue;
            }

            // Пробуем разные форматы дат
            $date = $this->parseDate($data[$fieldName]);

            if ($date) {
                $setter = 'set' . ucfirst($fieldName);
                $entity->$setter($date);
            } else {
                if ($errors) {
                    $this->addError(
                        $entity,
                        $fieldName,
                        'Invalid date format for ' . $fieldName . '. Supported formats: DD/MM/YYYY, YYYY-MM-DD, DD.MM.YYYY',
                        null,
                        $errors
                    );
                }
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Пытается распарсить дату в различных форматах
     */
    private function parseDate(string $dateString): ?\DateTime
    {
        foreach ($this->supportedFormats as $format) {
            $date = \DateTime::createFromFormat($format, $dateString);
            if ($date && $date->format($format) === $dateString) {
                return $date;
            }
        }

        return null;
    }

    /**
     * Определяет, является ли поле типом DateTime
     */
    public function isDateField(object $entity, string $fieldName): bool
    {
        try {
            $reflection = new ReflectionClass($entity);

            if (!$reflection->hasProperty($fieldName)) {
                return false;
            }

            $property = $reflection->getProperty($fieldName);
            $type = $property->getType();

            if ($type) {
                $typeName = $type->getName();
                return $typeName === \DateTime::class || $typeName === \DateTimeInterface::class || $typeName === \DateTimeImmutable::class;
            }
        } catch (\Exception $e) {
            // В случае ошибки просто возвращаем false
        }

        return false;
    }
}