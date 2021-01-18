<?php

namespace App\Traits\DbQuery;

use App\Models\Model;

trait Update
{
    public function update(array $data, array $id)
    {
        try {
            // Destruct id
            // list($idKey, $idVal) = $id;
            $idKey = array_keys($id)[0];
            $idVal = array_values($id)[0];

            $query = "UPDATE " . Model::$table . " SET";
            foreach ($data as $field => $value) {
                $query .= " {$field} = :{$field},";
            }

            $query = rtrim($query, ",");
            $query .= " WHERE {$idKey} = :idKey";

            $this->stmt = Model::$conn->prepare($query);

            foreach ($data as $field => $value) {
                $this->bind(":{$field}", $value);
            }

            // Bind id values
            $this->bind(":idKey", $idVal);

            $this->stmt->execute();
            $this->stmt->closeCursor();
            $this->stmt->fetch();

            $result = $this->stmt->rowCount();

            return $result;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }
}
