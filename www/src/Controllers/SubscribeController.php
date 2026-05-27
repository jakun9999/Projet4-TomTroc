<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Views\View;

/**
 * Controller for the subscribe page to allow 
 * users to create an account.
 */
class SubscribeController
{
    public function showSubscribe(): void
    {
        $view = new View('TomTroc - Inscription');
        $view->render('subscribe');
    }
}