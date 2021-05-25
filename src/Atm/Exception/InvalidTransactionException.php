<?php

declare(strict_types=1);

namespace App\Atm\Exception;

use App\Core\Exception\ApiExceptionInterface;
use App\Core\Exception\NoDataApiExceptionTrait;
use Symfony\Component\HttpFoundation\Response;

class InvalidTransactionException extends \RuntimeException implements ApiExceptionInterface
{
    use NoDataApiExceptionTrait;

    public function __construct(int $code = 0, \Throwable $previous = null)
    {
        parent::__construct('Invalid transaction.', $code, $previous);
    }

    public function getStatus(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function getTitle(): string
    {
        return 'INVALID_TRANSACTION';
    }
}
