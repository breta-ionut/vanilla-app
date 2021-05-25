<?php

declare(strict_types=1);

namespace App\Core\Routing;

class Route
{
    /**
     * @var string[]
     */
    private array $parameters;

    /**
     * @param string|string[] $controller
     * @param string[]|null $methods
     */
    public function __construct(
        private string $name,
        private string $pattern,
        private string|array $controller,
        private ?array $methods = null,
        private array $options = [],
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @return string|string[]
     */
    public function getController(): string|array
    {
        return $this->controller;
    }

    public function hasMethods(): bool
    {
        return null !== $this->methods;
    }

    /**
     * @return string[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    public function hasOption(string $name): bool
    {
        return isset($this->options[$name]);
    }

    public function getOption(string $name): mixed
    {
        return $this->options[$name];
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return string[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param string[] $parameters
     *
     * @return $this
     */
    public function setParameters(array $parameters): static
    {
        $this->parameters = $parameters;

        return $this;
    }
}
