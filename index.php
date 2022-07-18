<?php

include 'db1.php';

Db1::getInstance("localhost", "practik", "postgres", "postgres");

// Db1::insert("users", "login, email, password", "'555', '555', '555'");
// Db1::delete("users", "login = '555'");

$result = Db1::read("users");
foreach ($result as $row) {
    print $row['id'] . " -- " . $row['login'] . " -- " . $row['email'] . " -- " . $row['password'] . "<br>";
}

?>