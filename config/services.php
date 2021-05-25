<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Atm\Card\Authentication;
use App\Atm\Card\CardStorage;
use App\Atm\Http\CardControllerHooks;
use App\Atm\Repository\CardRepository;
use App\Atm\Repository\TransactionRepository;
use App\Atm\Transaction\AbstractHandler;
use App\Atm\Transaction\DepositHandler;
use App\Atm\Transaction\Handlers;
use App\Atm\Transaction\WithdrawHandler;
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

    $services->set(CardControllerHooks::class)
        ->args([service(Authentication::class)])
        ->public();

    $services->set(CardRepository::class)->parent(AbstractRepository::class);
    $services->set(TransactionRepository::class)->parent(AbstractRepository::class);

    $services->set(AbstractHandler::class)
        ->args([service(CardStorage::class), service(CardRepository::class), service(TransactionRepository::class)])
        ->abstract();

    $services->set(DepositHandler::class)
        ->parent(AbstractHandler::class)
        ->public();

    $services->set(WithdrawHandler::class)
        ->parent(AbstractHandler::class)
        ->public();

    $services->set(Handlers::class)
        ->args([service('service_container')])
        ->public();
};
