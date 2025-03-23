<?php

namespace App\Service\EntityField\Processor;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class ErrorProcessor
{
    public function __construct(
        private ValidatorInterface  $validator,
        private SerializerInterface $serializer
    ) {
    }

    public function processErrors(object $entity, ConstraintViolationList $validationErrors): ?JsonResponse
    {
        $errors = $this->validator->validate($entity);

        foreach ($validationErrors as $error) {
            $errors->add($error);
        }

        if ($errors->count() > 0) {
            return new JsonResponse(
                $this->serializer->serialize($errors, 'json'),
                Response::HTTP_BAD_REQUEST,
                [],
                true
            );
        }

        return null;
    }
}