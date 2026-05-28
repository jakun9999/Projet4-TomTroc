<?php
require_once __DIR__ . '/../src/bootstrap.php';

use Ml\App\Controllers\HomeController;
use Ml\App\Controllers\BooksController;
use Ml\App\Controllers\MessagingController;
use Ml\App\Controllers\AccountController;
use Ml\App\Controllers\LoginController;
use Ml\App\Controllers\SubscribeController;
use Ml\App\Controllers\ErrorController;
use Ml\App\Services\Web;

/** Routing page */
$action = Web::getAction();

try {
    switch ($action) {
        case null:
        case '':
        case 'home':
            $controller = new HomeController();
            $controller->showHome();
            break;
        case 'books':
            $controller = new BooksController();
            $controller->showBooks();
            break;
        case 'messaging':
            $controller = new MessagingController();
            $controller->showMessaging();
            break;
        case 'account':
            $controller = new AccountController();
            $controller->showAccount();
            break;
        case 'login':
            $controller = new LoginController();
            $controller->showLogin();
            break;
        case 'subscribe':
            $controller = new SubscribeController();
            $controller->showSubscribe();
            break;
        default:
            http_response_code(404);
            $controller = new ErrorController();
            $controller->showError('TomTroc - Erreur', ErrorController::ERRCODE_PAGE_DOES_NOT_EXISTS);
            break;
    }
} catch (\Throwable $e) {
    http_response_code(500);
    $controller = new ErrorController();
    $controller->showError('TomTroc - Erreur', ErrorController::ERRCODE_EXCEPTION, [
        'exception_message' => $e->getMessage(),
        'exception_trace' => $e->getTrace()
    ]);
}
