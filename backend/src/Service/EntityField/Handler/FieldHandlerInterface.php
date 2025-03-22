<?php

namespace App\Service\EntityField\Handler;

interface FieldHandlerInterface
{
    public function supports(string $fieldType): bool;
}