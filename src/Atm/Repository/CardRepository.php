<?php

declare(strict_types=1);

namespace App\Atm\Repository;

use App\Atm\Model\Card;
use App\Core\Database\AbstractRepository;

class CardRepository extends AbstractRepository
{
    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    public function commit(): void
    {
        $this->connection->commit();
    }

    public function findOneByIdLocked(int $id): ?Card
    {
        $stmt = $this->connection->prepare('SELECT * FROM cards WHERE id = :id FOR UPDATE');
        $stmt->execute([':id' => $id]);

        return $stmt->fetchObject(Card::class) ?? null;
    }

    public function findOneByHolderName(string $holderName): ?Card
    {
        $stmt = $this->connection->prepare('SELECT * FROM cards WHERE holderName = :holderName');
        $stmt->execute([':holderName' => $holderName]);

        return $stmt->fetchObject(Card::class);
    }

    public function updateSold(Card $card): void
    {
        $stmt = $this->connection->prepare('UPDATE cards SET sold = :sold WHERE id = :id');
        $stmt->execute([':sold' => $card->getSold(), ':id' => $card->getId()]);
    }
}
