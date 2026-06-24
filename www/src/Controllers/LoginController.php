<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Models\UserManager;
use Ml\App\Services\Web;
use Ml\App\Views\View;

/**
 * Controller for the login page to allow 
 * users to log in to their account.
 */
class LoginController
{
    private UserManager $userManager;

    /**
     * LoginController constructor.
     * 
     * Initialize class managers.
     */
    public function __construct()
    {
        $this->userManager = new UserManager();
    }

    /**
     * Manage call to empty login page. 
     */
    public function show(): void
    {
        $view = new View('TomTroc - Connexion');
        $view->render('login');
        return;
    }

    /**
     * Authenticate the visitor as user.
     * 
     * Only possible if a correct CSRF token is provided.
     */
    public function authenticate(): void
    {
        // If CSRF token fails, redirect to
        // empty login page.
        if (!Web::controlCsrfToken()) {
            header('location: /login');
            exit();
        }

        // CSRF token is correct we can proceed to 
        // authentication management.
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        $errors = [];
        if ($email === false || is_null($email) || $password === '') {
            $errors['login_message'] = 'Email ou mot de passe incorrect';
            $errors['email_value'] = $email;
            unset($password);
            $this->showError($errors);
            return;
        }

        $user = $this->userManager->getUserByEmail($email);

        if (
            is_null($user) ||
            $user === false ||
            !$this->userManager->authenticate($user, $email, $password)
        ) {
            $errors['login_message'] = 'Email ou mot de passe incorrect';
            $errors['email_value'] = $email;
            unset($user);
            unset($password);
            $this->showError($errors);
            return;
        }

        // We store the $user in $_SESSION global without
        // password information
        $user->setPassword('');
        unset($password);
        $_SESSION['user'] = $user;

        header('location: /home');
        return;
    }

    /**
     * Manages end of session for the user and returns
     * to homepage.
     */
    public function logout(): void
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
            header('location: /home');
            exit();
        }
    }

    /**
     * Function to give feedback to visitor trying
     * to login with incorrect information.
     * 
     * @param array $params containing possible errors
     */
    private function showError(array $params): void
    {
        $view = new View('TomTroc - Login');
        $view->render('login', $params);
        return;
    }
}
