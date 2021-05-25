<?php

declare(strict_types=1);

namespace App\Atm\Exception;

use App\Core\Exception\ApiExceptionInterface;
use App\Core\Exception\NoDataApiExceptionTrait;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationFailedException extends \RuntimeException implements ApiExceptionInterface
{
    use NoDataApiExceptionTrait;

    public function __construct(int $code = 0, \Throwable $previous = null)
    {
        parent::__construct('Authentication failed.', $code, $previous);
    }

    public function getStatus(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }

    public function getTitle(): string
    {
        return 'AUTHENTICATION_FAILED';
    }
}
