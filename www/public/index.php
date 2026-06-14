<?php
require_once __DIR__ . '/../src/bootstrap.php';

use Ml\App\Controllers\AccountController;
use Ml\App\Controllers\BooksController;
use Ml\App\Controllers\ErrorController;
use Ml\App\Controllers\HomeController;
use Ml\App\Controllers\LoginController;
use Ml\App\Controllers\MessagingController;
use Ml\App\Controllers\SubscribeController;
use Ml\App\Services\Web;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

/** Routing page */
$action = Web::getAction();
$homeController = new HomeController();
$booksController = new BooksController();
$messagingController = new MessagingController();
$accountController = new AccountController();
$loginController = new LoginController();
$subscribeController = new SubscribeController();
$errorController = new ErrorController();

try {
    switch ($action) {
        case null:
        case '':
        case 'home':
            $homeController->showHome();
            break;
        case 'book':
            $booksController->showBook();
            break;
        case 'books':
            $booksController->showBooks();
            break;
        case 'new-book':
            $booksController->newBook();
            break;
        case 'edit-book':
            $booksController->editBook();
            break;
        case 'add-book':
            $booksController->addBook();
            break;
        case 'update-book':
            $booksController->updateBook();
            break;
        case 'messaging':
            $messagingController->showMessaging();
            break;
        case 'new-message':
            $messagingController->newMessage();
            break;
        case 'send-message':
            $messagingController->sendMessage();
            break;
        case 'show-discussion':
            $messagingController->showDiscussion();
            break;
        case 'account':
            $accountController->showAccount();
            break;
        case 'update-account':
            $accountController->updateAccount();
            break;
        case 'delete-book':
            $booksController->deleteBook();
        case 'public-account':
            $accountController->showPublicAccount();
            break;
        case 'login':
            $loginController->showLogin();
            break;
        case 'authenticate':
            $loginController->authenticate();
            break;
        case 'subscribe':
            $subscribeController->showSubscribe();
            break;
        case 'register':
            $subscribeController->register();
            break;
        case 'logout':
            $loginController->logout();
            break;
        case 'unread-count':
            $messagingController->getUnreadMessagesCount();
            break;
        default:
            http_response_code(404);
            $errorController->showError('TomTroc - Erreur', ErrorController::ERRCODE_PAGE_DOES_NOT_EXISTS);
            break;
    }
} catch (\Throwable $e) {
    http_response_code(500);
    // $controller = new ErrorController();
    // $controller->showError('TomTroc - Erreur', ErrorController::ERRCODE_EXCEPTION, [
    //     'exception_message' => $e->getMessage()
    // ]);
    // ON CORCOURT TOUT : On affiche l'erreur directement de manière brute
    echo "<h1>🚨 Erreur Fatale Détectée</h1>";
    echo "<p><strong>Message :</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Fichier :</strong> " . $e->getFile() . " à la ligne " . $e->getLine() . "</p>";
    echo "<h3>Trace :</h3><pre>" . $e->getTraceAsString() . "</pre>";
    exit; // On arrête le script ici
}
