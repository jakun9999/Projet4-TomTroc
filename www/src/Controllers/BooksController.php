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
    /**
     * Display the list of books available for exchange.
     */
    public function showBooks(): void
    {
        $view = new View('TomTroc - Nos livres');
        $view->render('books');
    }

    /**
     * Display the form to edit an existing book.
     */
    public function editBook(): void
    {
        $view = new View('TomTroc - Edition du livre');
        $view->render('edit-book', ['mode' => 'edit']);
    }

    /**
     * Display the form to add a new book.
     */
    public function newBook(): void
    {
        $view = new View('TomTroc - Ajouter un livre');
        $view->render('edit-book', ['mode' => 'new']);
    }

    /**
     * Add a new book to the collection.
     */
    public function addBook(): void {}
}
