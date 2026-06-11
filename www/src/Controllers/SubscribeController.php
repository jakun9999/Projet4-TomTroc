<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Models\User;
use Ml\App\Models\UserManager;
use Ml\App\Services\Web;
use Ml\App\Views\View;

/**
 * Controller for the subscribe page to allow 
 * users to create an account.
 */
class SubscribeController
{
    private UserManager $userManager;

    /**
     * Subscribe Controller constructor.
     * 
     * Initialize class managers.
     */
    public function __construct()
    {
        $this->userManager = new UserManager();
    }

    /**
     * Call subscription page to display it.
     * 
     */
    public function showSubscribe(): void
    {
        $view = new View('TomTroc - Inscription');
        $view->render('subscribe');
        return;
    }

    /**
     * Manages subscription details using
     * UserManager model.
     */
    public function register(): void
    {
        // We check if CSRF token is correct
        // if not we redirect to subscription empty page
        if (!Web::controlCsrfToken()) {
            header('location: /subscribe');
            exit();
        }

        $pseudo = mb_strtolower(Web::sanitizeShortString($_POST['pseudo'] ?? ''));
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        // We control if input data are correct
        $errors = [];
        if ($pseudo === '') {
            $errors['pseudo_message'] = 'Un pseudonyme correct doit être défini';
        }

        if ($email === false || is_null($email)) {
            $errors['email_message'] = 'Un email correct doit être défini';
        }

        if (!Web::isPasswordSecure($password)) {
            $errors['password_message'] = 'Utilisez un mot de passe de 8 caractères ou plus, 
                                            incluant majuscule, minuscule, chiffre et caractères spéciaux
                                            (@$!%*?&#_\-)';
        }

        if (!empty($errors)) {
            $errors['pseudo_value'] = $pseudo;
            $errors['email_value'] = $email;
            $this->showSubscribeError($errors);
            return;
        }

        $user = new User($pseudo, $email, $password);


        // We check if pseudo and email are not already used by another user
        if ($this->userManager->isPseudoExist($pseudo)) {
            $errors['pseudo_message'] = 'Ce pseudonyme est déjà utilisé';
        }
        if ($this->userManager->isEmailExist($email)) {
            $errors['email_message'] = 'Cet email est déjà utilisé';
        }

        if (!empty($errors)) {
            $this->showSubscribeError($errors);
            return;
        }

        $this->userManager->addUser($user);
        $view = new View('TomTroc - Connexion');
        $view->render('login', ['subscription_successful' => true]);
        return;
    }

    /**
     * Function to give feedback to visitor trying
     * to subscribe with incorrect information.
     * 
     * @param array $params containing possible errors
     * based on defined const in class SubscribeController.
     */
    private function showSubscribeError(array $params): void
    {
        $view = new View('TomTroc - Inscription');
        $view->render('subscribe', $params);
        return;
    }
}
