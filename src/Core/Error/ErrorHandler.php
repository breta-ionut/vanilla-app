<?php

declare(strict_types=1);

namespace App\Core\Error;

use App\Core\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

class ErrorHandler
{
    private static self $handler;

    private function __construct(private bool $debug)
    {
    }

    public static function register(bool $debug): void
    {
        if (isset(self::$handler)) {
            return;
        }

        self::$handler = new self($debug);

        \set_error_handler(\Closure::fromCallable([self::$handler, 'handleError']));
        \set_exception_handler(\Closure::fromCallable([self::$handler, 'handleException']));
    }

    /**
     * @throws \ErrorException
     */
    private function handleError(int $type, string $message, string $file = null, int $line = null): bool
    {
        if (!($type & \error_reporting())) {
            return true;
        }

        throw new \ErrorException($message, 0, $type, $file, $line);
    }

    private function handleException(\Throwable $exception): void
    {
        $content = new ErrorPage((string) $exception, $this->debug);
        $status = $exception instanceof HttpExceptionInterface
            ? $exception->getStatus()
            : Response::HTTP_INTERNAL_SERVER_ERROR;

        (new Response((string) $content, $status))->send();
    }
}
