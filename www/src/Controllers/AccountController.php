<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Views\View;

/**
 * Controller for the account management page to allow
 * the user to view and edit her/his account information
 * and book list.
 */
class AccountController
{
    public function showAccount(): void
    {
        $view = new View('TomTroc - Mon compte');
        $view->render('account');
    }
}