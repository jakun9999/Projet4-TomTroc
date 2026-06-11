<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Models\BookManager;
use Ml\App\Models\UserManager;
use Ml\App\Views\View;
use Ml\App\Services\Web;

/**
 * Controller for the account management page to allow
 * the user to view and edit her/his account information
 * and book list.
 */
class AccountController
{

    private UserManager $userManager;
    private BookManager $bookManager;

    /**
     * AccountController Constructor.
     * 
     * Initialize class managers.
     */
    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->bookManager = new BookManager();
    }

    /**
     * Calls rendering of public-account view/template
     * 
     * Provides user, books list and books count to the template.
     */
    public function showPublicAccount(): void
    {
        $pseudo = filter_input(INPUT_GET, 'pseudo');
        $user = $this->userManager->getUserByPseudo($pseudo);

        $books = $this->bookManager->getBooksByUserId($user->getId());
        $booksCount = count($books);

        $view = new View('TomTroc - Profil');
        $view->render(
            'public-account',
            [
                'user' => $user,
                'books' => $books,
                'books_count' => $booksCount,
            ]
        );
    }

    /**
     * Show the account management page to current user.
     * 
     * Only usable if the visitor is an authenticate user.
     */
    public function showAccount(): void
    {
        if (isset($_SESSION['user'])) {
            $books =  $this->bookManager->getBooksByUserId($_SESSION['user']->getId());
            $booksCount = count($books);

            $view = new View('TomTroc - Mon compte');
            $view->render(
                'account',
                [
                    'books' => $books,
                    'books_count' => $booksCount,
                ]
            );
            return;
        }

        header('location: /login');
        exit();
    }

    /**
     * Update the account information.
     *  
     * Update email, password and pseudo of the user.
     */
    public function updateAccount(): void
    {
        // First we check that controller is called by an authenticate user
        // and with a valid CSRF token.
        if (!isset($_SESSION['user']) && !Web::controlCsrfToken()) {
            header('location: /login');
            exit();
        }

        $pseudo = Web::sanitizeShortString($_POST['pseudo'] ?? '');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        // We control if input data are correct
        $erros = [];
        if ($pseudo === '') {
            $errors['pseudo_message'] = 'Un pseudonyme correct doit être défini';
        }

        if ($email === false || is_null($email)) {
            $errors['email_message'] = 'Un email correct doit être défini';
        }

        if ($email !== $_SESSION['user']->getEmail() && $this->userManager->isEmailExist($email)) {
            $errors['email_message'] = "L'email est déjà utilisé.";
        }

        if ($pseudo !== $_SESSION['user']->getPseudo() && $this->userManager->isPseudoExist($pseudo)) {
            $errors['pseudo_message'] = "Le pseudo est déjà utilisé.";
        }

        if (!Web::isPasswordSecure($password)) {
            $errors['password_message'] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.";
        }

        // If any incorrect inputs were provided we reload 
        // account view.
        if (!empty($errors)) {
            $books = $this->bookManager->getBooksByUserId($_SESSION['user']->getId());
            $booksCount = count($books);
            $erros['books'] = $books;
            $errors['books_count'] = $booksCount;

            $view = new View('TomTroc - Mon compte');
            $view->render('account', $errors);
            return;
        }

        // Before updating the user we need to check if the password input
        // is the same than in the database.
        $passwordChanged = false;
        $user = $this->userManager->getUserByEmail($_SESSION['user']->getEmail());
        if (!$this->userManager->authenticate($user, $user->getEmail(), $password)) {
            $passwordChanged = true;
        }
        unset($user);

        // Management of image upload.
        $file = $_FILES['cover'] ?? null;
        $photo = Web::uploadImage($file) ?? '';

        $this->userManager->updateUser($_SESSION['user'], $pseudo, $email, $password, $photo);
        $modifiedValues['success'] = true;

        if ($_SESSION['user']->getEmail() !== $email) {
            $modifiedValues = ['email_message' => "L'email a été mis à jour avec succès."];
        }

        if ($_SESSION['user']->getPseudo() !== $pseudo) {
            $modifiedValues['pseudo_message'] = "Le pseudo a été mis à jour avec succès.";
        }

        if ($passwordChanged) {
            $modifiedValues['password_message'] = "Le mot de passe a été mis à jour avec succès.";
        }

        // For security reasons we don't want to keep password in memory.
        unset($password);

        // And we update current logged user with new email, pseudo and photo.
        $_SESSION['user']->setEmail($email);
        $_SESSION['user']->setPseudo($pseudo);
        $_SESSION['user']->setPhoto($photo);
        header('location: /account');
        exit();
    }
}
