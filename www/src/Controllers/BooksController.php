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

    public function editBook(): void
    {
        $view = new View('TomTroc - Edition du livre');
        $view->render('edit-book', ['mode' => 'edit']);
    }

    public function addBook(): void
    {
        $view = new View('TomTroc - Ajouter un livre');
        $view->render('edit-book', ['mode' => 'add']);
    }
}
