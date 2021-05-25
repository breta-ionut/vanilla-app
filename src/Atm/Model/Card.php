<?php

declare(strict_types=1);

namespace App\Atm\Model;

class Card
{
    private int $id;
    private string $holderName;
    private string $pin;
    private float $sold;

    public function getId(): int
    {
        return $this->id;
    }

    public function getHolderName(): string
    {
        return $this->holderName;
    }

    public function getPin(): string
    {
        return $this->pin;
    }

    public function getSold(): float
    {
        return $this->sold;
    }

    /**
     * @return $this
     */
    public function incSold(float $by): static
    {
        $this->sold += $by;

        return $this;
    }

    /**
     * @return $this
     */
    public function decSold(float $by): static
    {
        $this->sold -= $by;

        return $this;
    }

    public function __serialize(): array
    {
        return [$this->id];
    }

    public function __unserialize(array $data): void
    {
        [$this->id] = $data;
    }
}
