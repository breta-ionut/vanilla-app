<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use App\Core\Controller\AbstractController;
use App\Core\Controller\ExceptionControllerInterface;
use App\Core\Controller\HtmlExceptionController;
use App\Core\Controller\JsonExceptionController;
use App\Core\Routing\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class ControllerResolver
{
    private const EXCEPTIONS_CONTROLLERS_PER_FORMAT = [
        'json' => JsonExceptionController::class,
    ];

    private const DEFAULT_EXCEPTION_CONTROLLER = HtmlExceptionController::class;

    public function __construct(private ContainerInterface $container)
    {
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function resolve(Route $route): callable
    {
        $controller = $route->getController();

        if (\is_string($controller)) {
            $class = $controller;
            $method = '__invoke';
        } else {
            if (!isset($controller[0]) || !isset($controller[1])) {
                throw new \InvalidArgumentException(\sprintf(
                    'The controller for route "%s" must consist of a class and one of its methods.',
                    $route->getName(),
                ));
            }

            $class = $controller[0];
            $method = $controller[1];
        }

        $controller = $this->instantiateController($class);

        return [$controller, $method];
    }

    public function resolveForException(Request $request): ExceptionControllerInterface
    {
        $format = $request->getPreferredFormat();
        $class = isset(self::EXCEPTIONS_CONTROLLERS_PER_FORMAT[$format])
            ? self::EXCEPTIONS_CONTROLLERS_PER_FORMAT[$format]
            : self::DEFAULT_EXCEPTION_CONTROLLER;

        return $this->instantiateController($class);
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function instantiateController(string $class): AbstractController
    {
        if (!\is_subclass_of($class, AbstractController::class)) {
            throw new \InvalidArgumentException(\sprintf(
                'All controllers must extend "%s".',
                AbstractController::class,
            ));
        }

        /** @var AbstractController $controller */
        $controller = new $class();
        $controller->setContainer($this->container);

        return $controller;
    }
}
