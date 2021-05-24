<?php

declare(strict_types=1);

namespace App\Core\Controller;

use App\Core\Exception\ApiExceptionInterface;
use App\Core\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class JsonExceptionController extends AbstractController implements ExceptionControllerInterface
{
    public function error(Request $request, \Throwable $exception): Response
    {
        $status = $exception instanceof HttpExceptionInterface
            ? $exception->getStatus()
            : Response::HTTP_INTERNAL_SERVER_ERROR;

        $data = [
            'type' => 'https://tools.ietf.org/html/rfc2616#section-10',
            'title' => $exception instanceof ApiExceptionInterface ? $exception->getTitle() : 'UNKNOWN_ERROR',
            'status' => $status,
            'detail' => Response::$statusTexts[$status],
        ];

        if ($this->getParameter('kernel.debug')) {
            $data['debug'] = (string) $exception;
        }

        if ($exception instanceof ApiExceptionInterface && $exception->hasData()) {
            $data += $this->get(NormalizerInterface::class)->normalize($exception->getData());
        }

        return $this->toJson($data, [], $status);
    }
}
