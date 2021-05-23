<?php

use App\Core\Kernel;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/vendor/autoload.php';

$kernel = new Kernel((bool) ($_SERVER['APP_ENV'] ?? true));

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
