<?php

declare(strict_types=1);

namespace App\Atm\Card;

use App\Atm\Exception\AuthenticationFailedException;
use App\Atm\Exception\AuthorizationFailedException;
use App\Atm\Model\Card;
use App\Atm\Model\Credentials;
use App\Atm\Repository\CardRepository;
use Symfony\Component\HttpFoundation\Session\Session;

class Authentication
{
    public function __construct(
        private CardRepository $repository,
        private Session $session,
        private CardStorage $storage,
    ) {
    }

    /**
     * @throws AuthenticationFailedException
     */
    public function identify(Credentials $credentials): Card
    {
        $card = $this->repository->findOneByHolderName($credentials->getHolderName());
        if (null === $card) {
            throw new AuthenticationFailedException();
        }

        if (!\password_verify($credentials->getRawPin(), $card->getPin())) {
            throw new AuthenticationFailedException();
        }

        return $card;
    }

    public function initialize(Card $card): void
    {
        $this->session->set('card', $card);
        $this->storage->setCard($card);
    }

    /**
     * @throws AuthorizationFailedException
     */
    public function resume(): void
    {
        if (!$this->session->has('card') || !($card = $this->session->get('card') instanceof Card)) {
            throw new AuthorizationFailedException();
        }

        /** @var Card $card */
        $card = $this->repository->findOneById($card->getId());
        if (null === $card) {
            throw new AuthorizationFailedException();
        }

        $this->storage->setCard($card);
    }
}
