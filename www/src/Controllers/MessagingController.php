<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Models\Discussion;
use Ml\App\Models\DiscussionManager;
use Ml\App\Models\UserManager;
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
    public function newMessage(): void
    {
        // If visitor is not an authenticated user, we redirect him
        // to login page.
        if (!isset($_SESSION['user'])) {
            header('location: /login');
            exit();
        }

        $otherUserId = filter_input(INPUT_GET, 'to', FILTER_VALIDATE_INT);

        if (is_null($otherUserId) || $otherUserId === false) {
            header('location: /books');
        }

        $discussionManager = new DiscussionManager();
        $discussions = $discussionManager->getAllDiscussionByUserId($_SESSION['user']->getId());
        $selectedDiscussion = null;

        foreach ($discussions as $discussion) {
            if (
                $discussion->getUser1Id === $otherUserId ||
                $discussion->getUser2Id === $otherUserId
            ) {
                $selectedDiscussion = $discussion;
                break;
            }
        }

        if (is_null($selectedDiscussion)) {
            $userManager = new UserManager();
            $otherUser = $userManager->getUserById($otherUserId);

            $selectedDiscussion = new Discussion(
                $_SESSION['user']->getId(),
                $otherUserId,
                $_SESSION['user']->getPseudo(),
                $otherUser->getPseudo(),
                $_SESSION['user']->getPhoto(),
                $otherUser->getPhoto()
            );

            $discussions[] = $selectedDiscussion;

            // unset this temp user for security reason, avoiding to keep
            // it in memory with its password.
            unset($otherUser);
        }

        $view = new View('TomTroc - Messagerie');
        $view->render('messaging', [
            'discussions' => $discussions,
            'selected_discussion' => $selectedDiscussion
        ]);
        return;
    }

    /**
     * Called when the message form is used to manage recording and display of 
     * a new message sent by the user.
     */
    public function sendMessage(): void {}
}
