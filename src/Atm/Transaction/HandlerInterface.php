<?php

declare(strict_types=1);

namespace App\Atm\Transaction;

use App\Atm\Model\Transaction;

interface HandlerInterface
{
    public function handle(Transaction $transaction): void;
}
