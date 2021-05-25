<?php

declare(strict_types=1);

namespace App\Atm\Controller;

use App\Atm\Card\Authentication;
use App\Atm\Model\Credentials;
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
}
