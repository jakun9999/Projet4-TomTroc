<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Views\View;

/**
 * Controller for the error page to display an error message
 * when an error occurs or a page is not found.
 */
class ErrorController
{
    public function showError(string $message): void
    {
        $view = new View('TomTroc - Erreur');
        $view->render('error', ['message' => $message]);
    }
}
