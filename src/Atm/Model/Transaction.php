<?php

declare(strict_types=1);

namespace App\Atm\Model;

class Transaction
{
    public const TYPE_WITHDRAW = 1;
    public const TYPE_DEPOSIT = 2;

    private const TYPES = [
        self::TYPE_WITHDRAW,
        self::TYPE_DEPOSIT,
    ];

    private int $id;
    private int $type;
    private float $amount;

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return $this
     */
    public function setType(int $type): static
    {
        if (!\in_array($type, self::TYPES)) {
            throw new \DomainException(\sprintf(
                'Unknown type "%d". Available types: %s',
                $type,
                \json_encode(self::TYPES),
            ));
        }

        $this->type = $type;

        return $this;
    }

    public function isWithdraw(): bool
    {
        return self::TYPE_WITHDRAW === $this->type;
    }

    public function isDeposit(): bool
    {
        return self::TYPE_DEPOSIT === $this->type;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return $this
     */
    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }
}
