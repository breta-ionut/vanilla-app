<?php

declare(strict_types=1);

namespace App\Atm\Repository;

use App\Atm\Model\Transaction;
use App\Core\Database\AbstractRepository;

class TransactionRepository extends AbstractRepository
{
    public function save(Transaction $transaction): void
    {
        $stmt = $this->connection->prepare('INSERT INTO transactions (type, amount) VALUES (:type, :amount)');
        $stmt->execute([':type' => $transaction->getType(), ':amount' => $transaction->getAmount()]);
    }
}
