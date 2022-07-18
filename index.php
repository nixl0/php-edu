<?php

include 'db1.php';
include 'user.php';

Db1::getInstance("localhost", "practik", "postgres", "postgres");

// Db1::insert("users", "login, email, password", "'555', '555', '555'");
// Db1::delete("users", "login = '555'");

$user = new User();

$user->get("id = 4");
// echo "<br>";
// echo $user->id . " " . $user->login . " " . $user->email . " " . $user->password;
// echo "<br>";

// $user->login = "niiiiiiiiiiiiiiice";
// $user->edit();

$user->get("id = 4");
echo "<br>";
echo $user->id . " " . $user->login . " " . $user->email . " " . $user->password;
echo "<br>";

echo "<br><br><br>";


$result = Db1::read("users");
// print_r($result);
foreach ($result as $row) {
    print $row['id'] . " -- " . $row['login'] . " -- " . $row['email'] . " -- " . $row['password'] . "<br>";
}

?>