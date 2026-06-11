<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Views\View;

/**
 * Controller for the error page to display an error message
 * when an error occurs or a page is not found.
 */
class ErrorController
{
    public const ERRCODE_UNKNOWN = 0;
    public const MSG_UNKOWN = "Une erreur s'est produite";
    public const ERRCODE_PAGE_DOES_NOT_EXISTS = 1;
    public const MSG_PAGE_DOES_NOT_EXISTS = "404 - La page demandée n'existe pas";
    public const ERRCODE_EXCEPTION = 2;

    /**
     * Function in charge of displaying error page like 404 page not found.
     */
    public function showError(string $title, int $errorCode, array $params = []): void
    {
        switch ($errorCode) {
            case ErrorController::ERRCODE_PAGE_DOES_NOT_EXISTS:
                $view = new View('TomTroc - Erreur 404');
                $view->render('error', ['message' => ErrorController::MSG_PAGE_DOES_NOT_EXISTS]);
                break;
            case ErrorController::ERRCODE_EXCEPTION:
                if (isset($params['exception_message'])) {
                    $view = new View('TomTroc - Erreur');
                    $view->render('error', $params);
                    break;
                } else {
                    $view = new View('TomTroc - Erreur');
                    $view->render('error', ['message' => ErrorController::MSG_UNKOWN]);
                    break;
                }
            default:
                $view = new View('TomTroc - Erreur');
                $view->render('error', ['message' => ErrorController::MSG_UNKOWN]);
                break;
        }
    }
}
