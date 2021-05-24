<?php

declare(strict_types=1);

namespace App\Core\Error;

class ErrorPage
{
    public function __construct(private string $error, private bool $debug)
    {
    }

    public function __toString(): string
    {
        $error = $this->debug ? $this->error : 'Oops! An error occurred :(';

        return <<<HTML
<!DOCTYPE html>
<head>
    <title>Error</title>
</head>
<body>
    <h1>Error</h1>

    <p>$error</p>
</body>
HTML;
    }
}
