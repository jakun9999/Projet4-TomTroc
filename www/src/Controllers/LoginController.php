<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Models\UserManager;
use Ml\App\Views\View;
use Ml\App\Services\Web;

/**
 * Controller for the login page to allow 
 * users to log in to their account.
 */
class LoginController
{

    /**
     * Manage call to empty login page. 
     */
    public function showLogin(): void
    {
        $view = new View('TomTroc - Connexion');
        $view->render('login');
    }

    /**
     * If a CSRF token exists, we try to authenticate 
     * the user.
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

        if ($email === false || is_null($email) || $password === '') {
            $errors['login_message'] = 'Email ou mot de passe incorrect';
            $errors['email_value'] = $email;
            unset($password);
            $this->showLoginError($errors);
            return;
        }

        $userManager = new UserManager();
        $user = $userManager->getUserByEmail($email);

        if (is_null($user) || $user === false || !$userManager->authenticate($user, $email, $password)) {
            $errors['login_message'] = 'Email ou mot de passe incorrect';
            $errors['email_value'] = $email;
            unset($user);
            unset($password);
            $this->showLoginError($errors);
            return;
        } else {

            // We store the $user in $_SESSION global without
            // password information
            $user->setPassword('');
            unset($password);
            $_SESSION['user'] = $user;
            header('location: /home');
            return;
        }
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
    private function showLoginError(array $params): void
    {
        $view = new View('TomTroc - Login');
        $view->render('login', $params);
    }
}
