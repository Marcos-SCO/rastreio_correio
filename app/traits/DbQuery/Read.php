<?php

namespace App\Traits\DbQuery;

use App\Models\Model;

trait Read
{
    public function selectAll($fetchAll = true)
    {
        try {
            $query = "SELECT * FROM " . Model::$table;
            $this->stmt = Model::$conn->prepare($query);
            $this->stmt->execute();

            // Fetch results
            $result = $fetchAll ? $this->stmt->fetchAll() : $this->stmt->fetch();

            $this->stmt->closeCursor();
            return $result;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function selectBy($field, $value, $fetchAll = false)
    {
        try {
            $query = "SELECT * FROM " . MOdel::$table . " WHERE {$field} = :{$field}";

            $this->stmt = Model::$conn->prepare($query);
            $this->bind(":{$field}", $value);
            $this->stmt->execute();

            return $fetchAll ? $this->stmt->fetchAll() : $this->stmt->fetch();
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }
}
