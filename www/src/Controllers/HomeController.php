<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Views\View;

/**
 * Controller for the home page to display 
 * the main landing page.
 */
class HomeController
{
    public function showHome(): void
    {
        $view = new View('TomTroc - Accueil');
        $view->render('home');
    }
}
