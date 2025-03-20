<?php

// src/Validator/UniqueEmail.php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute] class UniqueEmail extends Constraint
{
    public string $message = 'This email is already registered.';
}
