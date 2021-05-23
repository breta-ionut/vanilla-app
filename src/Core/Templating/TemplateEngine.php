<?php

declare(strict_types=1);

namespace App\Core\Templating;

class TemplateEngine
{
    public function __construct(private string $templatesPath)
    {
    }

    /**
     * @throws \RuntimeException
     */
    public function render(string $template, array $parameters = []): string
    {
        $templatePath = \sprintf('%s/%s', $this->templatesPath, $template);
        if (!\file_exists($templatePath)) {
            throw new \RuntimeException(\sprintf('No template could be located at "%s".', $templatePath));
        }

        unset($template);
        \extract($parameters, \EXTR_SKIP);

        \ob_start();

        include $templatePath;

        return \ob_get_clean();
    }
}
