<?php

declare(strict_types=1);

namespace App\Atm\Http;

use App\Atm\Card\Authentication;
use App\Core\Http\ControllerHooksInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CardControllerHooks implements ControllerHooksInterface
{
    public function __construct(private Authentication $authentication)
    {
    }

    public function preController(Request $request): void
    {
        $this->authentication->enable();
    }

    public function postController(Request $request, Response $response): void
    {
        $this->authentication->suspend();
    }
}
