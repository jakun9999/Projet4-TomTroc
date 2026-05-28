<?php

declare(strict_types=1);

namespace Ml\App\Models;

/**
 * Abstract class for all model managers. Should not be instantiated directly.
 * Make $database property protected, so it can be used in all managers that extend this class.
 */
class AbstractClassManager
{
    protected DatabaseManager $database;

    /**
     * Constructor for the abstract class manager.
     */
    public function __construct()
    {
        $this->database = DatabaseManager::getInstance();
    }
}
