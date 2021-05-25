<?php

declare(strict_types=1);

use App\Atm\Controller\CardController;
use App\Atm\Http\CardControllerHooks;
use App\Core\Http\ControllerHooksInterface;
use App\Core\Routing\Route;
use App\Frontend\Controller\IndexController;
use Symfony\Component\HttpFoundation\Request;

return [
    new Route('app_atm_card_authenticate', '/^\/api\/card\/authenticate$/', [CardController::class, 'authenticate'], [Request::METHOD_POST]),

    new Route('app_atm_card_withdraw', '/^\/api\/card\/withdraw/', [CardController::class, 'withdraw'], [Request::METHOD_POST], [ControllerHooksInterface::CONTROLLER_HOOKS => CardControllerHooks::class]),
    new Route('app_atm_card_deposit', '/^\/api\/card\/deposit/', [CardController::class, 'deposit'], [Request::METHOD_POST], [ControllerHooksInterface::CONTROLLER_HOOKS => CardControllerHooks::class]),
    new Route('app_atm_card_get_sold', '/^\/api\/card\/sold/', [CardController::class, 'getSold'], [Request::METHOD_GET],  [ControllerHooksInterface::CONTROLLER_HOOKS => CardControllerHooks::class]),

    new Route('app_frontend_index', '/^\//', IndexController::class),
];
