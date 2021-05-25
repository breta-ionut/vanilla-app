<?php

declare(strict_types=1);

namespace App\Atm\Model;

use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Amount
{
    public function __construct(private float $amount)
    {
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public static function loadValidationMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('amount', new GreaterThan(0));
    }
}
