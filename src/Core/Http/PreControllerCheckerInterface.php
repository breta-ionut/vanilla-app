<?php

declare(strict_types=1);

namespace App\Core\Http;

use Symfony\Component\HttpFoundation\Request;

interface PreControllerCheckerInterface
{
    public const PRE_CONTROLLER_CHECKER = 'pre_controller_checker';

    public function check(Request $request): void;
}
