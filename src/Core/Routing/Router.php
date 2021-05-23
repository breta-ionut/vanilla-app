<?php

declare(strict_types=1);

namespace App\Core\Routing;

use App\Core\Exception\NoRouteFoundException;
use Symfony\Component\HttpFoundation\Request;

class Router
{
    /**
     * @var Route[]
     */
    private array $routes;

    public function __construct(private string $routesPath)
    {
    }

    /**
     * @throws NoRouteFoundException
     */
    public function match(Request $request): Route
    {
        $this->loadRoutes();

        $method = $request->getMethod();
        $path = $request->getPathInfo();

        foreach ($this->routes as $route) {
            if ($route->hasMethods() && !\in_array($method, $route->getMethods(), true)) {
                continue;
            }

            if (!\preg_match_all($route->getPattern(), $path, $matches)) {
                continue;
            }

            $route->setParameters(\array_filter(
                $matches,
                static fn(mixed $key): bool => \is_string($key),
                \ARRAY_FILTER_USE_KEY,
            ));

            return $route;
        }

        throw new NoRouteFoundException($path, $method);
    }

    private function loadRoutes(): void
    {
        if (!isset($this->routes)) {
            $this->routes = include $this->routesPath;
        }
    }
}
