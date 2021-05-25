<?php

declare(strict_types=1);

namespace App\Core\Exception;

use Symfony\Component\HttpFoundation\Response;

class BadInputException extends \RuntimeException implements ApiExceptionInterface
{
    use NoDataApiExceptionTrait;

    public function __construct(int $code = 0, \Throwable $previous = null)
    {
        parent::__construct('Bad input.', $code, $previous);
    }

    public function getStatus(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function getTitle(): string
    {
        return 'BAD_INPUT';
    }
}
