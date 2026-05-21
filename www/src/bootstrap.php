<?php

/**
 * Bootstrap file for the application.
 * Only included in index.php to set up the environment, 
 * load configurations and start the session.
 */
require_once __DIR__ . '/../config/conf.php';
require_once __DIR__ . '/../vendor/autoload.php';

session_start();
