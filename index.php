<?php

include 'db1.php';
include 'user.php';

Db1::authorize("localhost", "practik", "postgres", "postgres");
// $result = Db::query()->select("*", "users")->where("id > 300")->orderBy("login asc")->execute();
// echo Db1::query()->deleteFrom("users")->where("id = 21")->getSql() . "<br>";
// echo Db1::query()->update("users", ["email" => "gmail"])->where("id = 30")->getSql() . "<br>";

$tim = new User("tim", "timco@co.co", "timdabest");
$tim->add();

$result = Db1::query()->select("*", "users")->execute();
foreach ($result as $row) {
    print $row['id'] . " -- " . $row['login'] . " -- " . $row['email'] . " -- " . $row['password'] . "<br>";
}

?>