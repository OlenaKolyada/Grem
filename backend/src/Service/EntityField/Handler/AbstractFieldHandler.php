<?php

namespace App\Service\EntityField\Handler;

abstract class AbstractFieldHandler implements FieldHandlerInterface
{
    abstract public function supports(string $fieldType): bool;
}