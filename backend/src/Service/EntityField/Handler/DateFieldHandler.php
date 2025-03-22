<?php

namespace App\Service\EntityField\Handler;

use App\Service\EntityField\FieldErrorHandler;
use App\Service\EntityField\FieldTypeDetector;
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

    public function __construct(
        private readonly FieldTypeDetector $fieldTypeDetector,
        private readonly FieldErrorHandler $errorHandler
    ) {
    }

    public function supports(string $fieldType): bool
    {
        return in_array($fieldType, ['date', 'datetime', 'datetime_immutable']);
    }

    /**
     * Определяет, является ли поле типом DateTime
     */
    public function isDateField(object $entity, string $fieldName): bool
    {
        return $this->fieldTypeDetector->isDateField($entity, $fieldName);
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
                    $this->errorHandler->addError(
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
                    $this->errorHandler->addError(
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
}