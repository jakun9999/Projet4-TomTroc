<?php

declare(strict_types=1);

namespace Ml\App\Controllers;

use Ml\App\Models\BookManager;
use Ml\App\Views\View;

/**
 * Controller for the home page to display 
 * the main landing page.
 */
class HomeController
{
    private BookManager $bookManager;

    /**
     * Homecontroller constructor.
     * 
     * Initialize class managers.
     */
    public function __construct()
    {
        $this->bookManager = new BookManager();
    }

    /**
     * Call for view/template for the home page.
     */
    public function show(): void
    {
        $books = $this->bookManager->getLastFourBooks();
        $view = new View('TomTroc - Accueil');
        $view->render('home', ['books' => $books]);
        return;
    }
}
