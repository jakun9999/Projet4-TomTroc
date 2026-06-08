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

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

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
        case 'book':
            $controller = new BooksController();
            $controller->showBook();
            break;
        case 'books':
            $controller = new BooksController();
            $controller->showBooks();
            break;
        case 'new-book':
            $controller = new BooksController();
            $controller->newBook();
            break;
        case 'edit-book':
            $controller = new BooksController();
            $controller->editBook();
            break;
        case 'add-book':
            $controller = new BooksController();
            $controller->addBook();
            break;
        case 'update-book':
            $controller = new BooksController();
            $controller->updateBook();
            break;
        case 'messaging':
            $controller = new MessagingController();
            $controller->showMessaging();
            break;
        case 'account':
            $controller = new AccountController();
            $controller->showAccount();
            break;
        case 'update-account':
            $controller = new AccountController();
            $controller->updateAccount();
            break;
        case 'delete-book':
            $controller = new BooksController();
            $controller->deleteBook();
        case 'public-account':
            $controller = new AccountController();
            $controller->showPublicAccount();
            break;
        case 'login':
            $controller = new LoginController();
            $controller->showLogin();
            break;
        case 'authenticate':
            $controller = new LoginController();
            $controller->authenticate();
            break;
        case 'subscribe':
            $controller = new SubscribeController();
            $controller->showSubscribe();
            break;
        case 'register':
            $controller = new SubscribeController();
            $controller->register();
            break;
        case 'logout':
            $controller = new LoginController();
            $controller->logout();
            break;
        default:
            http_response_code(404);
            $controller = new ErrorController();
            $controller->showError('TomTroc - Erreur', ErrorController::ERRCODE_PAGE_DOES_NOT_EXISTS);
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
