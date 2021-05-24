<?php

declare(strict_types=1);

namespace App\Core\Controller;

use App\Core\Error\ErrorPage;
use App\Core\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HtmlExceptionController extends AbstractController implements ExceptionControllerInterface
{
    public function error(Request $request, \Throwable $exception): Response
    {
        $debug = $this->container->getParameter('kernel.debug');

        if ($this->container->hasParameter('kernel.error_template')) {
            return $this->render($this->container->getParameter('kernel.error_template'), \compact($exception, $debug));
        }

        $content = new ErrorPage((string) $exception, $debug);

        $status = $exception instanceof HttpExceptionInterface
            ? $exception->getStatus()
            : Response::HTTP_INTERNAL_SERVER_ERROR;

        return new Response((string) $content, $status);
    }
}
