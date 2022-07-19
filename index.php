<?php

require_once "vendor/autoload.php";

use Nilixin\Edu\db\Db;
use Nilixin\Edu\model\User;
use Nilixin\Edu\db\Model;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, ".env");
$dotenv->load();

function printAllRows($table)
{
    $result = Db::read($table);
    foreach ($result as $row) {
        print $row['id'] . " -- " . $row['login'] . " -- " . $row['email'] . " -- " . $row['password'] . "<br>";
    }
}

function printModelObject(Model $object)
{
    print_r($object);
    foreach ($object->fields as $field) {
        echo $object->{$field};
    }
    echo "<br><br>";
}

Db::initialize();

printAllRows("users");