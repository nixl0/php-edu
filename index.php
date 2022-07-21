<?php

require_once "vendor/autoload.php";

use Nilixin\Edu\db\Db;
use Nilixin\Edu\model\User;
use Nilixin\Edu\db\Model;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, ".env");
$dotenv->load();

// function printModelObject(Model $object)
// {
//     print_r($object);
//     foreach ($object->fields as $field) {
//         echo $object->{$field};
//     }
//     echo "<br><br>";
// }

Db::init();

$user = new User();
$user->selectOne("id = 459");
$user->password = "amerika";

// $user1 = new User();
// $user1->login = "fox";
// $user1->email = "fox@fox.com";
// $user1->password = "wolf";
$user->edit();



// SELECT EXAMPLE
// $result = Db::select("*")
//                 ->from("users")
//                 // ->where("id = 15")
//                 ->getStatement();


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