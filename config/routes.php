<?php

declare(strict_types=1);

use App\Core\Routing\Route;
use App\Frontend\Controller\IndexController;

return [
    new Route('app_frontend_index', '/^\//', IndexController::class),
];
