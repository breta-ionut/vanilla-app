<?php

declare(strict_types=1);

namespace App\Atm\Repository;

use App\Atm\Model\Card;
use App\Core\Database\AbstractRepository;

class CardRepository extends AbstractRepository
{
    public function findOneById(int $id): ?Card
    {
        $stmt = $this->connection->prepare('SELECT * FROM cards WHERE id = :id');
        $stmt->execute([':id' => $id]);

        return $stmt->fetchObject(Card::class) ?? null;
    }

    public function findOneByHolderName(string $holderName): ?Card
    {
        $stmt = $this->connection->prepare('SELECT * FROM cards WHERE holderName = :holderName');
        $stmt->execute([':holderName' => $holderName]);

        return $stmt->fetchObject(Card::class);
    }
}
