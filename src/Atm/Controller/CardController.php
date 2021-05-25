<?php

declare(strict_types=1);

namespace App\Atm\Controller;

use App\Atm\Card\Authentication;
use App\Atm\Card\CardStorage;
use App\Atm\Model\Amount;
use App\Atm\Model\Credentials;
use App\Atm\Model\Transaction;
use App\Atm\Transaction\Handlers;
use App\Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CardController extends AbstractController
{
    public function authenticate(Request $request): JsonResponse
    {
        $credentials = $this->fromJson($request, Credentials::class);
        $this->validate($credentials);

        /** @var Authentication $authentication */
        $authentication = $this->container->get(Authentication::class);

        $card = $authentication->identify($credentials);
        $authentication->initialize($card);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    public function withdraw(Request $request): JsonResponse
    {
        /** @var Amount $amount */
        $amount = $this->fromJson($request, Amount::class);
        $this->validate($amount);

        $transaction = (new Transaction())
            ->setType(Transaction::TYPE_WITHDRAW)
            ->setAmount($amount->getAmount());

        $this->get(Handlers::class)
            ->get($transaction)
            ->handle($transaction);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    public function deposit(Request $request): JsonResponse
    {
        /** @var Amount $amount */
        $amount = $this->fromJson($request, Amount::class);
        $this->validate($amount);

        $transaction = (new Transaction())
            ->setType(Transaction::TYPE_DEPOSIT)
            ->setAmount($amount->getAmount());

        $this->get(Handlers::class)
            ->get($transaction)
            ->handle($transaction);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    public function getSold(): JsonResponse
    {
        $card = $this->get(CardStorage::class)->getCard();

        return new JsonResponse(['sold' => $card->getSold()]);
    }
}
