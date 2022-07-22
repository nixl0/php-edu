<?php

require_once "vendor/autoload.php";

use Nilixin\Edu\db\Db;
use Nilixin\Edu\model\User;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, ".env");
$dotenv->load();

Db::init();

$user = new User();
$user->selectOne("id = 2");
print($user);
// $user->delete();
// $user->selectOne("id = 70");
// print($user);


// print($user);
echo "<br><br>";

// $user->login = "blabla";
// $user->email = "random@bs.c";

// $user->edit();






















// SELECT EXAMPLE
// $result = Db::select("*")
//                 ->from("users")
//                 // ->where("id = 15")
//                 ->getStatement();

// var_dump($result);

// foreach ($result as $row) {
//     $isEven = true;
//     foreach ($row as $key => $value) {
//         if ($isEven) {
//             print $key . " -- " . $value . " | ";
//             $isEven = false;
//         }
//         else {
//             $isEven = true;
//         }
//     }
//     print "<br>";
// }

// UPDATE EXAMPLE DEPRECATED
// $result1 = Db::update("users", ["login" => "000", "email" => "000", "password" => "000"])->getStatement();
// var_dump($result1);

// INSERT EXAMPLE
// $result2 = Db::insert("users", "login, email, password", "'bye', 'bye', 'bye'")->getStatement();
// var_dump($result2);

// DELETE EXAMPLE
// $result3 = Db::delete("users")->where("id = 460")->getStatement();
// var_dump($result3);