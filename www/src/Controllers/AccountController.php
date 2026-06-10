<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Models\BookManager;
use Ml\App\Views\View;
use Ml\App\Models\UserManager;
use Ml\App\Services\Web;

/**
 * Controller for the account management page to allow
 * the user to view and edit her/his account information
 * and book list.
 */
class AccountController
{
    public function showPublicAccount(): void
    {
        $pseudo = filter_input(INPUT_GET, 'pseudo');
        $userManager = new UserManager();
        $user = $userManager->getUserByPseudo($pseudo);

        $bookManager = new BookManager();
        $books = $bookManager->getBooksByUserId($user->getId());
        $booksCount = count($books);

        $view = new View('TomTroc - Profil');
        $view->render(
            'public-account',
            [
                'user' => $user,
                'books' => $books,
                'books_count' => $booksCount
            ]
        );
    }

    /**
     *  Show the account management page.
     */
    public function showAccount(): void
    {
        if (isset($_SESSION['user'])) {
            $bookManager = new BookManager();
            $booksCount = count($bookManager->getBooksByUserId($_SESSION['user']->getId()));
            $view = new View('TomTroc - Mon compte');
            $view->render('account', [
                'books' => $bookManager->getBooksByUserId($_SESSION['user']->getId()),
                'books_count' => $booksCount
            ]);
            return;
        } else {
            header('location: /login');
            exit();
        }
    }

    /**
     *  Update the account information.
     *  
     * Update email, password and pseudo of the user.
     */
    public function updateAccount(): void
    {

        if (!isset($_SESSION['user']) || !Web::controlCsrfToken()) {
            header('location: /login');
            exit();
        }

        $pseudo = mb_strtolower(Web::sanitizeShortString($_POST['pseudo'] ?? ''));
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        $userManager = new UserManager();


        // We control if input data are correct
        if ($pseudo === '') {
            $errors['pseudo_message'] = 'Un pseudonyme correct doit être défini';
        }

        if ($email === false || is_null($email)) {
            $errors['email_message'] = 'Un email correct doit être défini';
        }

        if ($email !== $_SESSION['user']->getEmail() && $userManager->isEmailExist($email)) {
            $errors['email_message'] = "L'email est déjà utilisé.";
        }

        if ($pseudo !== $_SESSION['user']->getPseudo() && $userManager->isPseudoExist($pseudo)) {
            $errors['pseudo_message'] = "Le pseudo est déjà utilisé.";
        }

        if (!Web::isPasswordSecure($password)) {
            $errors['password_message'] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.";
        }

        if (!empty($errors)) {
            $view = new View('TomTroc - Mon compte');
            $bookManager = new BookManager();
            $booksCount = count($bookManager->getBooksByUserId($_SESSION['user']->getId()));
            $errors['books_count'] = $booksCount;
            $view->render('account', $errors);
            return;
        }

        // Before updating the user we need to check if the password input
        // is the same than in the database.
        $passwordChanged = false;
        $user = $userManager->getUserByEmail($_SESSION['user']->getEmail());
        if (!$userManager->authenticate($user, $user->getEmail(), $password)) {
            $passwordChanged = true;
        }
        unset($user);

        // Management of image upload
        $file = $_FILES['cover'] ?? null;
        $photo = Web::uploadImage($file) ?? '';

        $userManager->updateUser($_SESSION['user'], $pseudo, $email, $password, $photo);
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


        unset($password);

        $_SESSION['user']->setEmail($email);
        $_SESSION['user']->setPseudo($pseudo);
        header('location: /account');
        exit();
        // $bookManager = new BookManager();
        // $booksCount = count($bookManager->getBooksByUserId($_SESSION['user']->getId()));
        // $modifiedValues['books_count'] = $booksCount;
        // $view = new View('TomTroc - Mon compte');
        // $view->render('account', $modifiedValues);
    }
}
