<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Core\Routing\Router;
use App\Core\Templating\TemplateEngine;

return function (ContainerConfigurator $configurator): void {
    $configurator->parameters()
        ->set('kernel.routes_path', param('kernel.project_dir') . '/config/routes.php')
        ->set('kernel.templates_path', param('kernel.project_dir') . '/templates');

    $services = $configurator->services();

    $services->set(Router::class)
        ->args([param('kernel.routes_path')]);

    $services->set(TemplateEngine::class)
        ->args([param('kernel.templates_path')]);
};
