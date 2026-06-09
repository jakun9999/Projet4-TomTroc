<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Models\DiscussionManager;
use Ml\App\Views\View;

/**
 * Controller for the messaging page to allow 
 * users to communicate with each other.
 */
class MessagingController
{

    /**
     * Simply render messaging page with latest discussion message selected.
     * 
     */
    public function showMessaging(): void
    {
        // If visitor is not an authenticated user, we redirect him
        // to login page.
        if (!isset($_SESSION['user'])) {
            header('location: /login');
            exit();
        }

        $discussionManager = new DiscussionManager();
        $discussions = $discussionManager->getAllDiscussionByUserId($_SESSION['user']->getId());
        $view = new View('TomTroc - Messagerie');
        $view->render('messaging', ['discussions' => $discussions]);
    }

    /**
     * Display the messaging page with a new open discussion with a specific
     * user (used for example when coming from book detail page via send 
     * message button).
     */
    public function prepareMessage(): void {}

    /**
     * Called when the message form is used to manage recording and display of 
     * a new message sent by the user.
     */
    public function sendMessage(): void {}
}
