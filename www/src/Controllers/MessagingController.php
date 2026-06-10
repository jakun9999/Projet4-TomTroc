<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Models\Discussion;
use Ml\App\Models\DiscussionManager;
use Ml\App\Models\Message;
use Ml\App\Models\MessageManager;
use Ml\App\Models\UserManager;
use Ml\App\Views\View;
use Ml\App\Services\Web;

/**
 * Controller for the messaging page to allow 
 * users to communicate with each other.
 */
class MessagingController
{

    private DiscussionManager $discussionManager;
    private MessageManager $messageManager;

    public function __construct()
    {
        $this->discussionManager = new DiscussionManager();
        $this->messageManager = new MessageManager();
    }


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


        $discussions = $this->discussionManager->getAllDiscussionByUserId($_SESSION['user']->getId());
        $messages = [];
        foreach ($discussions as $discussion) {
            $messages[$discussion->getId()] = $this->messageManager->getAllMessageByDisccusionId($discussion->getId());
        }

        $view = new View('TomTroc - Messagerie');
        $view->render('messaging', [
            'discussions' => $discussions,
            'selected_discussion' => $discussions[0],
            'messages' => $messages
        ]);
        return;
    }

    public function showDiscussion(): void
    {
        // If visitor is not an authenticated user, we redirect him
        // to login page.
        if (!isset($_SESSION['user'])) {
            header('location: /login');
            exit();
        }

        $otherUserId = filter_input(INPUT_GET, 'with', FILTER_VALIDATE_INT);

        $discussions = $this->discussionManager->getAllDiscussionByUserId($_SESSION['user']->getId());
        $messages = [];
        foreach ($discussions as $discussion) {
            if ($discussion->getOtherUserId() === $otherUserId) {
                $selectedDiscussion = $discussion;
            }
            $messages[$discussion->getId()] = $this->messageManager->getAllMessageByDisccusionId($discussion->getId());
        }

        $view = new View('TomTroc - Messagerie');
        $view->render('messaging', [
            'discussions' => $discussions,
            'selected_discussion' => $selectedDiscussion ?? $discussions[0],
            'messages' => $messages
        ]);
        return;
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

        $discussions = $this->discussionManager->getAllDiscussionByUserId($_SESSION['user']->getId());
        $messages = [];
        // Creating the new discussion to be passed to template
        $selectedDiscussion = null;

        // We need to check if a discussion with the destination user
        // already exists
        foreach ($discussions as $discussion) {
            if ($discussion->getOtherUserId() === $otherUserId) {
                $selectedDiscussion = $discussion;
            }
            $messages[$discussion->getId()] = $this->messageManager->getAllMessageByDisccusionId($discussion->getId());
        }

        // If no discussion was already done with the destination user
        // we will create to new one.
        if (is_null($selectedDiscussion)) {
            $userManager = new UserManager();
            $otherUser = $userManager->getUserById($otherUserId);

            // if user id doesn't exists we redirect to book list.
            if (is_null($otherUser)) {
                header('location: /books');
                exit();
            }

            // We remove destination password from memory immediately
            // for security reason
            $otherUser->setPassword('');

            $selectedDiscussion = new Discussion(
                $_SESSION['user']->getId(),
                $otherUserId,
                $_SESSION['user']->getPseudo(),
                $otherUser->getPseudo(),
                $_SESSION['user']->getPhoto(),
                $otherUser->getPhoto()
            );

            // We add this new discussion to discussions[] array so that
            // template will be able to display it.
            $discussions[] = $selectedDiscussion;

            // unset this temp user for security reason, avoiding to keep
            // it in memory.
            unset($otherUser);
        } else {
            // a previous discussion exists, we load messages from this
            // selected discussion so that template can load it.

            $selectedDiscussionMessages = $this->messageManager->getAllMessageByDisccusionId(
                $selectedDiscussion->getId()
            );
        }

        $view = new View('TomTroc - Messagerie');
        $view->render('messaging', [
            'discussions' => $discussions,
            'selected_discussion' => $selectedDiscussion,
            'messages' => $messages
        ]);
        return;
    }

    /**
     * Called when the message form is used to manage recording and display of 
     * a new message sent by the user.
     */
    public function sendMessage(): void
    {
        if (!isset($_SESSION['user']) && !Web::controlCsrfToken()) {
            header('location: /login');
            exit();
        }

        $receiverId = filter_input(INPUT_POST, 'to', FILTER_VALIDATE_INT);
        $content = Web::sanitizeShortString($_POST['message']);
        $messageManager = new MessageManager();
        $message = new Message($_SESSION['user']->getId(), $content);
        $message = $messageManager->addMessage($message, $receiverId);

        header('location: /new-message?to=' . $receiverId);
        exit();
    }
}
