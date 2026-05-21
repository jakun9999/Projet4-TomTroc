<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Views\View;

/**
 * Controller for the messaging page to allow 
 * users to communicate with each other.
 */
class MessagingController
{
    public function showMessaging(): void
    {
        $view = new View('TomTroc - Messagerie');
        $view->render('messaging');
    }
}