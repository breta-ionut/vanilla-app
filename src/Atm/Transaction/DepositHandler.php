<?php

declare(strict_types=1);

namespace App\Atm\Transaction;

use App\Atm\Model\Card;
use App\Atm\Model\Transaction;

class DepositHandler extends AbstractHandler
{
    protected function handleCardSold(Card $card, Transaction $transaction): void
    {
        $card->incSold($transaction->getAmount());
    }
}