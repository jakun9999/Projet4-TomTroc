<?php
require_once __DIR__ . '/../src/bootstrap.php';

use Ml\App\Controllers\HomeController;
use Ml\App\Services\Web;

/** Routing page */
$action = Web::getAction();

switch ($action) {
    case 'index':
        $controller = new HomeController();
        $controller->showHome();
        break;
    default:
        $controller = new HomeController();
        $controller->showHome();
        break;
}
