<?php

require_once "vendor/autoload.php";

use Nilixin\Edu\db\Db;
use Nilixin\Edu\model\User;

Db::getInstance("localhost", "practik", "postgres", "postgres");


$user = new User();
$user->get("id = 200");

echo $user->id . " " . $user->login . " " . $user->email . " " . $user->password;
echo "<br><br>";


$result = Db::read("users");
// print_r($result);
foreach ($result as $row) {
    print $row['id'] . " -- " . $row['login'] . " -- " . $row['email'] . " -- " . $row['password'] . "<br>";
}

?>