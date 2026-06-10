<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Views\View;
use Ml\App\Models\Book;
use Ml\App\Models\BookManager;
use Ml\App\Models\User;
use Ml\App\Models\UserManager;
use Ml\App\Services\Web;

/**
 * Controller for the books page to display 
 * the list of available books for exchange.
 */
class BooksController
{

    /**
     * Display a specific book using its id
     */
    public function showBook(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? null;
        if (is_null($id) || $id === false) {
            header('location: /books');
            exit();
        } else {
            $bookManager = new BookManager();
            $book = $bookManager->getBookById($id);
            $userManager = new UserManager();
            $user = $userManager->getUserById($book->getUserId());
            if (is_null($book)) {
                header('location: /books');
                exit();
            } else {
                $view = new View('TomTroc - ' . $book->getTitle());
                $view->render('single-book', ['book' => $book, 'user' => $user]);
                return;
            }
        }
    }

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
        if (!isset($_SESSION['user'])) {
            header('location: /login');
            exit();
        }

        $bookId = filter_input(INPUT_GET, 'book', FILTER_VALIDATE_INT);
        $bookManager = new BookManager();
        $book = $bookManager->getBookById($bookId);
        if (isset($book) && $book->getUserId() === $_SESSION['user']->getId()) {
            $view = new View('TomTroc - Edition du livre');
            $view->render('edit-book', ['book' => $book, 'mode' => 'edit']);
            return;
        } else {
            header('location: /account');
            exit();
        }
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
        if (!isset($_SESSION['user'])) {
            header('location: /login');
            exit();
        }

        if (!Web::controlCsrfToken()) {
            header('location: /new-book');
            exit();
        }

        $title = Web::sanitizeShortString($_POST['title']);
        $author = Web::sanitizeShortString($_POST['author']);
        $description = Web::sanitizeShortString($_POST['description']);
        $status = Web::sanitizeShortString($_POST['status']) === 'true' ? 1 : 0;

        // Management of image upload
        $file = $_FILES['cover'] ?? null;
        $imageUrl = Web::uploadImage($file) ?? '';



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

    public function deleteBook(): void
    {
        if (!isset($_SESSION['user'])) {
            header('location: /login');
            exit();
        }

        $bookId = filter_input(INPUT_GET, 'book', FILTER_VALIDATE_INT);
        $bookManager = new BookManager();
        $book = $bookManager->getBookById($bookId);
        if (isset($book) && $book->getUserId() === $_SESSION['user']->getId()) {
            $bookManager->deleteBook($book->getId());
        }
        header('location: /account');
        exit();
    }
    /**
     * Update an existing book in the collection.
     */
    public function updateBook(): void
    {
        if (!isset($_SESSION['user'])) {
            header('location: /login');
            exit();
        }

        if (!Web::controlCsrfToken()) {
            header('location: /account');
            exit();
        }

        $title = Web::sanitizeShortString($_POST['title']);
        $author = Web::sanitizeShortString($_POST['author']);
        $description = Web::sanitizeShortString($_POST['description']);
        $status = Web::sanitizeShortString($_POST['status']) === 'true' ? 1 : 0;
        $id = filter_input(INPUT_POST, 'book', FILTER_VALIDATE_INT);

        // Management of image upload
        $file = $_FILES['cover'] ?? null;
        $imageUrl = Web::uploadImage($file) ?? '';


        if ($title === '') {
            $errors['title_message'] = 'Vous devez saisir un titre';
        }

        if ($author === '') {
            $errors['author_message'] = 'Vous devez saisir un auteur';
        }

        if ($description === '') {
            $errors['description_message'] = 'Vous devez saisir un commentaire';
        }

        $book = new Book(
            $title,
            $author,
            '',
            $description,
            $status,
            $_SESSION['user']->getId(),
            $imageUrl,
            $id
        );

        // If errors are present in $_POST data we redirect to the new
        // book page with already defined value.
        if (!empty($errors)) {
            $errors['book'] = $book;
            $errors['mode'] = 'edit';
            $view = new View('TomTroc - Ajouter un livre');
            $view->render('/edit-book', $errors);
            exit();
        }

        // Once the error checks are passed we can add the book.


        $bookManager = new BookManager();
        $bookManager->updateBook($book);

        // and redirect to user account page.
        header('location: /account');
        exit();
    }
}
