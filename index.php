<?php

include 'db.php';
include 'user.php';

Db::authorize("localhost", "practik", "postgres", "postgres");
$result = Db::query()->select("*", "users")->where("id > 300")->execute();

foreach ($result as $row) {
    print $row['id'] . " -- " . $row['login'] . " -- " . $row['email'] . " -- " . $row['password'] . "<br>";
}

?>