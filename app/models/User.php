<?php

namespace App\Models;

class User extends Model
{
    public function __construct()
    {
        Self::$table = 'users';
    }

    public function selectAllUsers()
    {
        return $this->selectAll();
    }

    public function selectUser($id)
    {
        // extract($id);

        return $this->selectBy("id", $id);
    }
}