<?php

declare(strict_types=1);

namespace App\Core\Database;

abstract class AbstractRepository
{
    public function __construct(protected \PDO $connection)
    {
    }
}
