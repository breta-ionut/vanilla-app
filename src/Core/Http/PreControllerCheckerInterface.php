<?php

declare(strict_types=1);

namespace App\Core\Http;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface ControllerHooksInterface
{
    public const CONTROLLER_HOOKS = 'controller_hooks';

    public function preController(Request $request): void;

    public function postController(Request $request, Response $response): void;
}
