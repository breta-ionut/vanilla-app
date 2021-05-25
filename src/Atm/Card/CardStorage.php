<?php

declare(strict_types=1);

namespace App\Atm\Card;

use App\Atm\Model\Card;

class CardStorage
{
    private Card $card;

    public function getCard(): Card
    {
        return $this->card;
    }

    /**
     * @return $this
     */
    public function setCard(Card $card): static
    {
        $this->card = $card;

        return $this;
    }
}
