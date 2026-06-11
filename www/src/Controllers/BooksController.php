<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Models\Book;
use Ml\App\Models\BookManager;
use Ml\App\Models\User;
use Ml\App\Models\UserManager;
use Ml\App\Services\Web;
use Ml\App\Views\View;

/**
 * Controller for the books page to display 
 * the list of available books for exchange.
 */
class BooksController
{
    private BookManager $bookManager;
    private UserManager $userManager;

    /**
     * BooksController constructor.
     * 
     * Initialize class managers.
     */
    public function __construct()
    {
        $this->bookManager = new BookManager();
        $this->userManager = new UserManager();
    }

    /**
     * Display a specific book using its id
     */
    public function showBook(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? null;
        // If the book id is incorrect, we redirect the visitor to the 
        // global library.
        if (is_null($id) || $id === false) {
            header('location: /books');
            exit();
        }

        $book = $this->bookManager->getBookById($id);
        $user = $this->userManager->getUserById($book->getUserId());

        if (is_null($book)) {
            header('location: /books');
            exit();
        }

        $view = new View('TomTroc - ' . $book->getTitle());
        $view->render(
            'single-book',
            [
                'book' => $book,
                'user' => $user,
            ]
        );
        return;
    }

    /**
     * Display the list of books available for exchange.
     */
    public function showBooks(): void
    {
        $books = $this->bookManager->getAllBooks();
        $view = new View('TomTroc - Nos livres');
        $view->render('books', ['books' => $books]);
    }

    /**
     * Display the form to edit an existing book.
     */
    public function editBook(): void
    {
        // Only available for a logged user, we redirect to login page.
        if (!isset($_SESSION['user'])) {
            header('location: /login');
            exit();
        }

        $bookId = filter_input(INPUT_GET, 'book', FILTER_VALIDATE_INT);
        $book = $this->bookManager->getBookById($bookId);

        // It must not be possible to edit a book from another user, 
        // so we also control it.
        if (isset($book) && $book->getUserId() === $_SESSION['user']->getId()) {
            $view = new View('TomTroc - Edition du livre');
            $view->render(
                'edit-book',
                [
                    'book' => $book,
                    'mode' => 'edit'
                ]
            );
            return;
        }

        // In other cases (logged user but not an own book or an invalid book
        // id, we redirect to account page).
        header('location: /account');
        exit();
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
        // We separate control for logged user check and 
        // CSRF token to redirect to the correct page. 
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

        $errors = [];
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
        // book page with already inputed values to avoid user to type again
        // everything.
        if (!empty($errors)) {
            $errors['title_value'] = $title;
            $errors['author_value'] = $author;
            $errors['description_value'] = $description;
            $errors['status_value'] = $status;
            $errors['mode'] = 'new';

            $view = new View('TomTroc - Ajouter un livre');
            $view->render('/edit-book', $errors);
            return;
        }

        // Once the error checks are passed we can add the book.
        $book = new Book(
            $title,
            $author,
            '',
            $description,
            $status,
            $_SESSION['user']->getId(),
            $imageUrl
        );
        $this->bookManager->addBook($book);

        // and redirect to user account page.
        header('location: /account');
        exit();
    }

    /**
     * Delete a specific book via its id.
     */
    public function deleteBook(): void
    {
        // a book can only be deleted by a logged user.
        if (!isset($_SESSION['user'])) {
            header('location: /login');
            exit();
        }

        $bookId = filter_input(INPUT_GET, 'book', FILTER_VALIDATE_INT);
        $book = $this->bookManager->getBookById($bookId);

        // and it can only be deleted by the owner of the book.
        if (isset($book) && $book->getUserId() === $_SESSION['user']->getId()) {
            $this->bookManager->deleteBook($book->getId());
        }

        header('location: /account');
        exit();
    }

    /**
     * Update an existing book in the collection.
     */
    public function updateBook(): void
    {
        // Not a logged user: redirected to login page.
        if (!isset($_SESSION['user'])) {
            header('location: /login');
            exit();
        }

        // Not a valid CSRF, this is abnormal, we redirect to account page.
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

        $errors = [];
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

            $view = new View('TomTroc - Edition du livre');
            $view->render('/edit-book', $errors);
            exit();
        }

        // Once the error checks are passed we can update the book.        
        $this->bookManager->updateBook($book);

        // and redirect to user account page.
        header('location: /account');
        exit();
    }
}
