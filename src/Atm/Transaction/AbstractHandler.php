<?php

declare(strict_types=1);

namespace App\Atm\Transaction;

use App\Atm\Card\CardStorage;
use App\Atm\Model\Card;
use App\Atm\Model\Transaction;
use App\Atm\Repository\CardRepository;
use App\Atm\Repository\TransactionRepository;

abstract class AbstractHandler implements HandlerInterface
{
    public function __construct(
        private CardStorage $cardStorage,
        private CardRepository $cardRepository,
        private TransactionRepository $transactionRepository,
    ) {
    }

    final public function handle(Transaction $transaction): void
    {
        $card = $this->cardStorage->getCard();

        $this->handleCardSold($card, $transaction);
        $this->cardRepository->updateSold($card);

        $this->transactionRepository->save($transaction);
    }

    abstract protected function handleCardSold(Card $card, Transaction $transaction): void;
}
