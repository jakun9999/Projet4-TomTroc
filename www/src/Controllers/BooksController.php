<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Views\View;
use Ml\App\Models\Book;
use Ml\App\Models\BookManager;
use Ml\App\Models\User;
use Ml\App\Services\Web;

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
        $bookManager = new BookManager();
        $books = $bookManager->getAllBooks();
        $view = new View('TomTroc - Nos livres');
        $view->render('books', ['books' => $books]);
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
    public function addBook(): void
    {
        if (!Web::controlCsrfToken()) {
            header('location: /new-book');
            exit();
        }

        $title = Web::sanitizeShortString($_POST['title']);
        $author = Web::sanitizeShortString($_POST['author']);
        $description = Web::sanitizeShortString($_POST['description']);
        $status = Web::sanitizeShortString($_POST['status']) === 'true' ? 1 : 0;
        $imageUrl = ''; // TODO: handle image upload and get the URL

        if ($title === '') {
            $errors['title_message'] = 'Vous devez saisir un titre';
        }

        if ($author === '') {
            $errors['author_message'] = 'Vous devez saisir un auteur';
        }

        if ($description === '') {
            $errors['description_message'] = 'Vous devez saisir un commentaire';
        }

        // If errors are present in $_POST data we redirect to the new
        // book page with already defined value.
        if (!empty($errors)) {
            $errors['title_value'] = $title;
            $errors['author_value'] = $author;
            $errors['description_value'] = $description;
            $errors['status_value'] = $status;
            $errors['mode'] = 'new';
            $view = new View('TomTroc - Ajouter un livre');
            $view->render('/edit-book', $errors);
            exit();
        }

        // Once the error checks are passed we can add the book.
        $book = new Book($title, $author, '', $description, $status, $_SESSION['user']->getId(), $imageUrl);

        $bookManager = new BookManager();
        $bookManager->addBook($book);

        // and redirect to user account page.
        header('location: /account');
        exit();
    }

    /**
     * Update an existing book in the collection.
     */
    public function updateBook(): void {}
}
