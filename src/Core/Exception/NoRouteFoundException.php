<?php

declare(strict_types=1);

namespace App\Core\Exception;

use Symfony\Component\HttpFoundation\Response;

class NoRouteFoundException extends \DomainException implements HttpExceptionInterface
{
    public function __construct(string $path, string $method, int $code = 0, \Throwable $previous = null)
    {
        $message = \sprintf('No route found for path "%s" and method "%s".', $path, $method);

        parent::__construct($message, $code, $previous);
    }

    public function getStatus(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
