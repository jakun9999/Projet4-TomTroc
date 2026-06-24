<?php
require_once __DIR__ . '/../src/bootstrap.php';

use Ml\App\Controllers\AccountController;
use Ml\App\Controllers\BookController;
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
$bookController = new BookController();
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
            $homeController->show();
            break;
        case 'book':
            $bookController->show();
            break;
        case 'books':
            $bookController->showAll();
            break;
        case 'new-book':
            $bookController->new();
            break;
        case 'edit-book':
            $bookController->edit();
            break;
        case 'add-book':
            $bookController->add();
            break;
        case 'update-book':
            $bookController->update();
            break;
        case 'messaging':
            $messagingController->show();
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
            $accountController->show();
            break;
        case 'update-account':
            $accountController->update();
            break;
        case 'delete-book':
            $bookController->delete();
        case 'public-account':
            $accountController->showPublic();
            break;
        case 'login':
            $loginController->show();
            break;
        case 'authenticate':
            $loginController->authenticate();
            break;
        case 'subscribe':
            $subscribeController->show();
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
            $errorController->show('TomTroc - Erreur', ErrorController::ERRCODE_PAGE_DOES_NOT_EXISTS);
            break;
    }
} catch (\Throwable $e) {
    http_response_code(500);
    // $controller = new ErrorController();
    // $controller->showError('TomTroc - Erreur', ErrorController::ERRCODE_EXCEPTION, [
    //     'exception_message' => $e->getMessage()
    // ]);
    // Raw display of errors
    echo "<h1>🚨 Erreur Fatale Détectée</h1>";
    echo "<p><strong>Message :</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Fichier :</strong> " . $e->getFile() . " à la ligne " . $e->getLine() . "</p>";
    echo "<h3>Trace :</h3><pre>" . $e->getTraceAsString() . "</pre>";
    exit;
}
