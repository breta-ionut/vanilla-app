<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Atm\Card\Authentication;
use App\Atm\Card\CardStorage;
use App\Atm\Repository\CardRepository;
use App\Core\Database\AbstractRepository;
use Symfony\Component\HttpFoundation\Session\Session;

return function (ContainerConfigurator $configurator): void {
    $configurator->parameters()
        ->set('database.host', param('env(MYSQL_HOST)'))
        ->set('database.name', param('env(MYSQL_DATABASE)'))
        ->set('database.user', param('env(MYSQL_USER)'))
        ->set('database.password', param('env(MYSQL_PASSWORD)'));

    $services = $configurator->services();

    $services->set(Authentication::class)
        ->args([service(CardRepository::class), service(Session::class), service(CardStorage::class)])
        ->public();

    $services->set(CardStorage::class);
    $services->set(CardRepository::class)->parent(AbstractRepository::class);
};
