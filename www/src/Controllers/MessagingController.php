<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Models\Discussion;
use Ml\App\Models\DiscussionManager;
use Ml\App\Models\Message;
use Ml\App\Models\MessageManager;
use Ml\App\Models\UserManager;
use Ml\App\Services\Web;
use Ml\App\Views\View;

/**
 * Controller for the messaging page to allow 
 * users to communicate with each other.
 */
class MessagingController
{

    private DiscussionManager $discussionManager;
    private MessageManager $messageManager;
    // Const used for mobile display of either discussion list or messages.
    const string MOBILE_CSS_DISCUSSION_ON = 'flex flex-col';
    const string MOBILE_CSS_DISCUSSION_OFF = 'hidden xl:flex xl:flex-col';
    const string MOBILE_CSS_MESSAGES_ON = 'flex flex-col';
    const string MOBILE_CSS_MESSAGES_OFF = 'hidden xl:flex xl:flex-col';


    /**
     * Messaging controller constructor.
     * 
     * Initialize class Managers.
     */
    public function __construct()
    {
        $this->discussionManager = new DiscussionManager();
        $this->messageManager = new MessageManager();
    }

    /**
     * Simply render messaging page with latest discussion message selected.
     * 
     */
    public function show(): void
    {
        // If visitor is not an authenticated user, we redirect him
        // to login page.
        if (!isset($_SESSION['user'])) {
            header('location: /login');
            exit();
        }

        // We gather all discussions and all messages for all discussions.
        // Messages are store in an associative array with discussion id as key.
        // Possible performance improvement: 
        // inner join to get only latest discussion messages.
        $discussions = $this->discussionManager->getAllDiscussionByUserId($_SESSION['user']->getId());
        $messages = [];
        foreach ($discussions as $discussion) {
            $messages[$discussion->getId()] =
                $this->messageManager->getAllMessageByDisccusionId($discussion->getId());
        }

        $view = new View('TomTroc - Messagerie');
        $view->render(
            'messaging',
            [
                'discussions' => $discussions,
                'selected_discussion' => $discussions[0] ?? null,
                'messages' => $messages,
                'mobile_css_discussions' => self::MOBILE_CSS_DISCUSSION_ON,
                'mobile_css_messages' => self::MOBILE_CSS_MESSAGES_OFF,
            ]
        );
        return;
    }

    /**
     * Calls for view/template on a specific discussion.
     */
    public function showDiscussion(): void
    {
        // If visitor is not an authenticated user, we redirect him
        // to login page.
        if (!isset($_SESSION['user'])) {
            header('location: /login');
            exit();
        }

        $currentUserId = $_SESSION['user']->getId();
        $otherUserId = filter_input(INPUT_GET, 'with', FILTER_VALIDATE_INT);

        $discussions = $this->discussionManager->getAllDiscussionByUserId($_SESSION['user']->getId());
        $messages = [];
        foreach ($discussions as $discussion) {
            if ($discussion->getOtherUserId() === $otherUserId) {
                $selectedDiscussion = $discussion;
            }
            $messages[$discussion->getId()] =
                $this->messageManager->getAllMessageByDisccusionId($discussion->getId());

            // Before displaying messaging page with specified discussion
            // we set unread messages of this discussion as read where the sender
            // is not current user.
            if (isset($selectedDiscussion)) {
                foreach ($messages[$selectedDiscussion->getId()] as $message) {
                    if ($message->getUserId() !== $currentUserId) {
                        // it change status in DB
                        $this->messageManager->setMessageRead($message->getId());
                        // it change status in message object
                        $message->setStatus(true);
                    }
                }
            }
        }

        $view = new View('TomTroc - Messagerie');
        $view->render(
            'messaging',
            [
                'discussions' => $discussions,
                'selected_discussion' => $selectedDiscussion ?? $discussions[0],
                'messages' => $messages,
                'mobile_css_discussions' => self::MOBILE_CSS_DISCUSSION_OFF,
                'mobile_css_messages' => self::MOBILE_CSS_MESSAGES_ON,
            ]
        );
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
            exit();
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
            $messages[$discussion->getId()] =
                $this->messageManager->getAllMessageByDisccusionId($discussion->getId());
        }

        // If no discussion was already done with the destination user
        // we will create to new empty one.
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
        }

        $view = new View('TomTroc - Messagerie');
        $view->render(
            'messaging',
            [
                'discussions' => $discussions,
                'selected_discussion' => $selectedDiscussion,
                'messages' => $messages,
                'mobile_css_discussions' => self::MOBILE_CSS_DISCUSSION_OFF,
                'mobile_css_messages' => self::MOBILE_CSS_MESSAGES_ON,
            ]
        );
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

        $message = new Message($_SESSION['user']->getId(), $content);
        $message = $this->messageManager->addMessage($message, $receiverId);

        //We redirect to a new conversation with the destination id.
        header('location: /new-message?to=' . $receiverId);
        exit();
    }

    /**
     * Only used for AJAX api to get unread count in nav bar
     * for authenticated users.
     * 
     */
    public function getUnreadMessagesCount(): void
    {
        // Only authorized for logged in people        
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Accès non autorisé']);
            exit;
        }

        $userId = $_SESSION['user']->getId();
        $count = $this->messageManager->getUnReadMessagesByUserId($userId);

        header('Content-Type: application/json');
        echo json_encode(['unread_messages_count' => $count]);
        exit;
    }
}
