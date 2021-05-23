<?php

declare(strict_types=1);

namespace App\Core\Controller;

use App\Core\Exception\BadInputExceptionInterface;
use App\Core\Templating\TemplateEngine;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractController implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @throws BadInputExceptionInterface
     */
    public function fromJson(Request $request, string $type, array $context = []): mixed
    {
        try {
            return $this->container
                ->get(SerializerInterface::class)
                ->deserialize($request->getContent(), $type, 'json', $context);
        } catch (ExceptionInterface $exception) {
            throw new BadInputExceptionInterface(0, $exception);
        }
    }

    public function render(string $template, array $parameters = [], Response $response = null): Response
    {
        if (null === $response) {
            $response = new Response();
        }

        $content = $this->container
            ->get(TemplateEngine::class)
            ->render($template, $parameters);

        return $response->setContent($content);
    }

    public function toJson(
        mixed $data,
        array $context = [],
        int $status = Response::HTTP_OK,
        array $headers = [],
    ): JsonResponse {
        $json = $this->container
            ->get(SerializerInterface::class)
            ->serialize($data, 'json', $context);

        return new JsonResponse($json, $status, $headers, true);
    }
}
