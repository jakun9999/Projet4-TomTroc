<?php

declare(strict_types=1);

namespace Ml\App\Models;

/**
 * Abstract class for all model managers. Should not be instantiated directly.
 * Make $database property protected, so it can be used in all managers that extend this class.
 */
abstract class AbstractClassManager
{
    protected DatabaseManager $database;

    /**
     * Constructor for the abstract class manager.
     * 
     * @param DatabaseManager $database To be used for tests.
     * Use as null in production.
     */
    public function __construct(?DatabaseManager $database = null)
    {
        $this->database = $database ?? DatabaseManager::getInstance();
    }
}
