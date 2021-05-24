<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return function (ContainerConfigurator $configurator): void {
    $configurator->parameters()
        ->set('database.host', param('env(MYSQL_HOST)'))
        ->set('database.name', param('env(MYSQL_DATABASE)'))
        ->set('database.user', param('env(MYSQL_USER)'))
        ->set('database.password', param('env(MYSQL_PASSWORD)'));
};
