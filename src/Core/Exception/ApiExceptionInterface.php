<?php

declare(strict_types=1);

namespace App\Core\Exception;

interface ApiExceptionInterface extends HttpExceptionInterface
{
    public function getTitle(): string;

    public function hasData(): bool;

    public function getData(): mixed;
}
