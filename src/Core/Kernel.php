<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Controller\ExceptionControllerInterface;
use App\Core\Error\ErrorHandler;
use App\Core\Kernel\ControllerResolver;
use App\Core\Routing\Route;
use App\Core\Routing\Router;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{
    private bool $booted = false;
    private string $projectDir;
    private ContainerBuilder $container;

    public function __construct(private bool $debug = false)
    {
    }

    public function handle(Request $request): Response
    {
        $this->boot();

        try {
            return $this->doHandle($request);
        } catch (\Throwable $exception) {
            return $this->handleException($request, $exception);
        }
    }

    private function boot(): void
    {
        if ($this->booted) {
            return;
        }

        ErrorHandler::register($this->debug);
        $this->container = $this->createContainer();

        $this->booted = true;
    }

    private function createContainer(): ContainerBuilder
    {
        $container = new ContainerBuilder();

        foreach ($this->getDefaultParameters() as $name => $value) {
            $container->setParameter($name, $value);
        }

        $loader = new PhpFileLoader($container, new FileLocator($this->getProjectDir()));

        $loader->load('src/Core/Resources/services.php');
        $loader->load('config/services.php');

        $container->compile(true);

        return $container;
    }

    private function getDefaultParameters(): array
    {
        return [
            'kernel.debug' => $this->debug,
            'kernel.project_dir' => $this->getProjectDir(),
        ];
    }

    private function getProjectDir(): string
    {
        if (!isset($this->projectDir)) {
            $this->projectDir = \realpath(__DIR__.'/../../');
        }

        return $this->projectDir;
    }

    private function doHandle(Request $request): Response
    {
        /** @var Route $route */
        $route = $this->container
            ->get(Router::class)
            ->match($request);

        $request->attributes->set('_route', $route);

        $controller = $this->container
            ->get(ControllerResolver::class)
            ->resolve($route);

        return $controller($request, $route->getParameters());
    }

    private function handleException(Request $request, \Throwable $exception): Response
    {
        /** @var ExceptionControllerInterface $controller */
        $controller = $this->container
            ->get(ControllerResolver::class)
            ->resolveForException($request);

        return $controller->error($request, $exception);
    }
}
