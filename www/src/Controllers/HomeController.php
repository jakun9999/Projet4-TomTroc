<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Models\BookManager;
use Ml\App\Views\View;

/**
 * Controller for the home page to display 
 * the main landing page.
 */
class HomeController
{
    public function showHome(): void
    {
        $bookManager = new BookManager();
        $books = $bookManager->getLastFourBooks();
        $view = new View('TomTroc - Accueil');
        $view->render('home', ['books' => $books]);
    }
}
