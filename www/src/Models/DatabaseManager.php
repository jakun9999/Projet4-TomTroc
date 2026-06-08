<?php

declare(strict_types=1);

namespace Ml\App\Models;

use PDO;
use PDOStatement;


/**
 * Class used for database connection and queries.
 * Should not be instantiated directly, use DatabaseManager::getInstance() instead.
 * 
 * @see DatabaseManager::getInstance() for getting the instance of this class.
 * 
 */
class DatabaseManager
{

    private static ?DatabaseManager $instance = null;

    private PDO $pdo;

    /**
     * Private constructor to prevent direct instantiation. Use getInstance() instead.
     */
    private function __construct()
    {
        // On se connecte à la base de données.
        $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_ROOT, DB_PASS);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * 
     */
    private function __clone(): void {}

    /**
     * 
     */
    public function __wakeup(): void {}

    /**
     * Returns the singleton instance of the DatabaseManager.
     * @return DatabaseManager
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Returns the PDO instance.
     * @return PDO
     */
    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    /**
     * Executes a SQL query.
     * 
     * If parameters are passed, a prepared statement is used.
     * 
     * @param string $sql : the SQL query to execute.
     * @param array|null $params : the parameters for the SQL query.
     * @return PDOStatement : the result of the SQL query.
     */
    public function query(string $sql, ?array $params = null): PDOStatement
    {
        if ($params === null || empty($params)) {
            return $this->pdo->query($sql);
        }

        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);

        return $statement;
    }
}
