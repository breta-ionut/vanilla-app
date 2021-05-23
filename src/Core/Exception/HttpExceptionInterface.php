<?php

declare(strict_types=1);

namespace App\Core\Exception;

interface HttpExceptionInterface
{
    public function getStatus(): int;
}
