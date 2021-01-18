<?php

require_once "./app/bootstrap.php";

// var_dump($_GET);

//$select = $model->select('users');
// var_dump($select);
// var_dump($select);

/*// Select *
$select = $db->select('users');
dump($select);*/

/*// Custom query with select
$customQuery = $db->customQuery("SELECT email FROM users WHERE id = :id AND email = :email", ['id' => 2, 'email' => 'marcos_sco@outlook.com']);
*/

/* //Insert example
 $insert = $db->insert('users', ['name' => 'Iron Maiden', 'email' => 'ironmaiden@outlook.com']);
*/

/* // Update
$update = $db->update('users', ['name' => 'haha', 'email' => 'haha@outlook.com'], ['id',8]);*/

/*// Delete
$delete = $db->delete('users', ['name' => 'Seven Son', 'email' => 'sevenson@outlook.com']);
$delete = $db->delete('users', ['id' => 24]);
dump($delete);*/