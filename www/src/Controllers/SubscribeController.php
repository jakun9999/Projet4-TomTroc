<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Views\View;

/**
 * Controller for the subscribe page to allow 
 * users to create an account.
 */
class SubscribeController
{

    public const ERRCODE_PSEUDO_ALREADY_EXISTS = 1;
    public const MSG_PSEUDO_ALREADY_EXISTS = "Le pseudonyme choisit est déjà utilisé";
    public const ERRCODE_EMAIL_ALREADY_EXISTS = 2;
    public const MSG_EMAIL_ALREADY_EXISTS = "L'email choisit est déjà utilisé";
    public const ERRCODE_PASSWORD_NOT_COMPLIANT = 3;
    public const MSG_PASSWORD_NOT_COMPLIANT =
    "Le mot de passe ne respecte pas les critères 
        de sécurité (8 caractères minimum, utliser des majuscules, 
        minuscules, chiffres et caractères spéciaux)";


    /**
     * Call view with empty subscription form
     */
    public function showSubscribe(): void
    {
        $view = new View('TomTroc - Inscription');
        $view->render('subscribe');
    }

    /**
     * Manages subscription details using
     * UserManager model.
     */
    public function Subscribe(): void {}

    /**
     * Function to give feedback to visitor trying
     * to subscribe with incorrect information.
     * 
     * @param array $params containing possible errors
     * based on defined const in class SubscribeController.
     */
    public function showSubscribeError(array $params): void
    {
        $view = new View('TomTroc - Inscription');
        $view->render('subscribe', $params);
    }
}
