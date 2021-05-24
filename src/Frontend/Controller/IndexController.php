<?php

declare(strict_types=1);

namespace App\Frontend\Controller;

use App\Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('frontend/index.html.php');
    }
}
