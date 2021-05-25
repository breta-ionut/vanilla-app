<?php

declare(strict_types=1);

use App\Atm\Controller\CardController;
use App\Core\Routing\Route;
use App\Frontend\Controller\IndexController;
use Symfony\Component\HttpFoundation\Request;

return [
    new Route('app_atm_card_authenticate', '/^\/api\/card\/authenticate$/', [CardController::class, 'authenticate'], [Request::METHOD_POST]),
    new Route('app_frontend_index', '/^\//', IndexController::class),
];
