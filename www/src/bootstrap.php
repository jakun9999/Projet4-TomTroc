<?php

/**
 * Bootstrap file for the application.
 * Only included in index.php to set up the environment, 
 * load configurations and start the session.
 */
require_once __DIR__ . '/../config/conf.php';
require_once __DIR__ . '/../vendor/autoload.php';

session_set_cookie_params([
    'lifetime' => 0,          // expires when browser is closed
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => true,         // only via https
    'httponly' => true,       // block xss attacks by stolen cookies
    'samesite' => 'Lax'        // Protection against CSRF breach
]);

session_start();
