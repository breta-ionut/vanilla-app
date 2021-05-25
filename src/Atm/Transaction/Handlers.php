<?php

declare(strict_types=1);

namespace App\Atm\Transaction;

use App\Atm\Model\Transaction;
use Psr\Container\ContainerInterface;

class Handlers
{
    public function __construct(private ContainerInterface $container)
    {
    }

    /**
     * @throws \DomainException
     */
    public function get(Transaction $transaction): HandlerInterface
    {
        switch (true) {
            case $transaction->isWithdraw():
                return $this->container->get(WithdrawHandler::class);

            case $transaction->isDeposit():
                return $this->container->get(DepositHandler::class);

            default:
                throw new \DomainException(\sprintf(
                    'No handler found for transaction of type "%d".',
                    $transaction->getType(),
                ));
        }
    }
}
