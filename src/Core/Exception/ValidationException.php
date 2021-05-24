<?php

declare(strict_types=1);

namespace App\Core\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \RuntimeException implements ApiExceptionInterface, NormalizableInterface
{
    public function __construct(
        private ConstraintViolationListInterface $violations,
        int $code = 0,
        \Throwable $previous = null,
    ) {
        parent::__construct('Validation errors.', $code, $previous);
    }

    public function getStatus(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function getTitle(): string
    {
        return 'VALIDATION_ERRORS';
    }

    public function hasData(): bool
    {
        return true;
    }

    public function getData(): mixed
    {
        return $this->violations;
    }

    /**
     * {@inheritDoc}
     */
    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = []): array
    {
        $violationsData = $normalizer->normalize($this->violations, $format, $context);

        return ['violations' => $violationsData];
    }
}
