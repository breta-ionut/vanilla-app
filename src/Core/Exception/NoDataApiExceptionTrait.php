<?php

declare(strict_types=1);

namespace App\Core\Exception;

trait NoDataApiExceptionTrait
{
    public function hasData(): bool
    {
        return false;
    }

    public function getData(): mixed
    {
        return null;
    }
}
