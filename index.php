<?php

require_once "vendor/autoload.php";

error_reporting(-1);
ini_set("display_errors", 1);

use Nilixin\Edu\db\Db;
use Nilixin\Edu\model\User;
use Nilixin\Edu\debug\Debug;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, ".env.local");
$dotenv->load();

Db::init();

$user = new User();

// $user->selectOne("id = 100");
// $user->login = "hello_world";
// $user->email = "hello@hel.hel";
// $user->password = "heeeeeeeee";
// Debug::prn($user);
// $user->edit();




















//$view = new View();
//$view->setTpl("public/tpl/main.html");
//$view->render($user);

// $content = file_get_contents("public/tpl/main.html");
// $content = str_replace("{{login}}", $user->login, $content);
// $content = str_replace("{{email}}", $user->email, $content);
// echo $content;

// print($user);


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