<?php

namespace App\Config;

use PDO;
use PDOException;

use App\Interfaces\DatabaseInterface;

class MySql implements DatabaseInterface
{
    public $pdo;

    public function __construct()
    {
        $this->connection();
    }

    /**
     * Get the PDO database connection
     * 
     * @return mixed
     */
    public function connection()
    {
        // Set dsn
        $dsn = 'mysql:host=' . $_ENV["HOST"] . ';port=.' . $_ENV["PORT"] . ';dbname=' . $_ENV['DBNAME'] . ';charset=utf8';

        $options = [
            PDO::ATTR_PERSISTENT => TRUE,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => FALSE
        ];

        try {
            $this->pdo = new PDO($dsn, $_ENV['USER'], $_ENV['PASSWORD'], $options);

            return $this->pdo;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
