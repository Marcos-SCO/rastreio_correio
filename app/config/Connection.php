<?php

namespace App\Config;

use App\Interfaces\DatabaseInterface;

class Connection
{
    public $db_connection;

    public function __construct(DatabaseInterface $conn)
    {
        return $this->db_connection = $conn->pdo;
    }
}
