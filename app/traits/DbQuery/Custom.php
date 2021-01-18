<?php

namespace App\Traits\DbQuery;

use App\Models\Model;

trait Custom
{    
    public function customQuery($query, array $data = null, $fetchAll = true)
    {
        try {
            $this->stmt = Model::$conn->prepare($query);
            if ($data) {
                foreach ($data as $field => $value) {
                    $this->bind(":{$field}", $value);
                }
            }

            $this->stmt->execute();

            $rowCount = $this->stmt->rowCount();

            // Fetch results
            $result = $fetchAll ? $this->stmt->fetchAll() : $this->stmt->fetch();

            $this->stmt->closeCursor();

            return $result;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }
}
