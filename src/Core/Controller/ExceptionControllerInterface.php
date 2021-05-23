<?php

declare(strict_types=1);

namespace App\Core\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface ExceptionControllerInterface
{
    public function error(Request $request, \Throwable $exception): Response;
}
