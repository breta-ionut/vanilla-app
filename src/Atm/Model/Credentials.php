<?php

declare(strict_types=1);

namespace App\Atm\Model;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Credentials
{
    public function __construct(private string $holderName, private string $rawPin)
    {
    }

    public function getHolderName(): string
    {
        return $this->holderName;
    }

    public function getRawPin(): string
    {
        return $this->rawPin;
    }

    public static function loadValidationConstraints(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('holderName', new NotBlank())
            ->addPropertyConstraints('rawPin', [new NotBlank(), new Length(4)]);
    }
}
