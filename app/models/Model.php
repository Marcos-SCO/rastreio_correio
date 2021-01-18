<?php

namespace App\Models;

use App\Config\Connection;
use App\Interfaces\DatabaseInterface;
use App\Traits\ApiMethods;

// Db query
use App\Traits\DbQuery\Custom;
use App\Traits\DbQuery\Create;
use App\Traits\DbQuery\Read;
use App\Traits\DbQuery\Update;
use App\Traits\DbQuery\Delete;
use App\Traits\DbQuery\BindValues;

class Model
{
    public static $conn;
    public static $table;

    use Custom;
    use Create;
    use Read;
    use Update;
    use Delete;
    use BindValues;
    use ApiMethods;

    public function __construct(Connection $connection)
    {
        return Self::$conn = $connection->db_connection;
    }
}
