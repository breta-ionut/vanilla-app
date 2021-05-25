<?php

declare(strict_types=1);

namespace App\Atm\Transaction;

use App\Atm\Exception\InvalidTransactionException;
use App\Atm\Model\Card;
use App\Atm\Model\Transaction;

class WithdrawHandler extends AbstractHandler
{
    /**
     * @throws InvalidTransactionException
     */
    protected function handleCardSold(Card $card, Transaction $transaction): void
    {
        if ($card->getSold() < $transaction->getAmount()) {
            throw new InvalidTransactionException();
        }

        $card->decSold($transaction->getAmount());
    }
}
