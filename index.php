<?php

include 'db.php';
include 'sql1.php';

$conn = Db::getInstance("localhost", "practik", "postgres", "postgres")->getConnection();

// $result = Sql::read($conn, "users");

// Sql::update($conn, "users", "password", "222", "login = 'based_guy81'");
// Sql::insert($conn, "users", "login, email, password", "111, 111, 111");
Sql1::delete($conn, "users", "id = 7");

$result = Sql1::read($conn, "users");


foreach ($result as $row) {
    print $row['id'] . " -- " . $row['login'] . " -- " . $row['email'] . " -- " . $row['password'] . "<br>";
}

?>