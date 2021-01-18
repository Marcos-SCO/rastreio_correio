<?php

namespace App\Traits\DbQuery;

use App\Models\Model;

trait Delete
{
    public function delete(array $data)
    {
        try {
            $query = "DELETE FROM " . Model::$table . " WHERE";

            foreach ($data as $field => $value) {
                $query .= " {$field} = :{$field} AND";
            }

            $query = rtrim($query, "AND");
            $this->stmt = Model::$conn->prepare($query);

            foreach ($data as $field => $value) {
                $this->bind(":{$field}", $value);
            }

            $this->stmt->execute();
            $this->stmt->closeCursor();

            $result = $this->stmt->rowCount();
            return $result;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }
}
