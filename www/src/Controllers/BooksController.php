<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Views\View;

/**
 * Controller for the books page to display 
 * the list of available books for exchange.
 */
class BooksController
{
    public function showBooks(): void
    {
        $view = new View('TomTroc - Nos livres');
        $view->render('books');
    }
}