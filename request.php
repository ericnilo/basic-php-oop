<?php

require 'vendor/autoload.php';

require 'config/db.connection.php';

$connection = $dbConnection['connection'];

$connectionSchema = new \DbDriver\ConnectionSchema(
    $dbConnection['driver'],
    $connection['host'],
    $connection['username'],
    $connection['password'],
    $connection['database']
);

$dbConnection = new DbDriver\DbConnection($connectionSchema);


$result = $dbConnection->get()->insert('users', [
    'username' => 'testeric',
    'password' => 'ericnilo'
]);

//$result = $dbConnection->get()->select('SELECT * FROM users WHERE user_id = 2');

print_r($result);
