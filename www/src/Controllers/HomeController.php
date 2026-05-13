<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Views\View;

class HomeController
{
    public function showHome(): void
    {
        $view = new View('Hello World');
        $view->render('hello');
    }
}
