<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Views\View;

/**
 * Controller for the login page to allow 
 * users to log in to their account.
 */
class LoginController
{
    public function showLogin(): void
    {
        $view = new View('TomTroc - Connexion');
        $view->render('login');
    }
}