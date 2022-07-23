<?php

require_once "vendor/autoload.php";

error_reporting(-1);
ini_set("display_errors", 1);

use Nilixin\Edu\db\Db;
use Nilixin\Edu\model\UserModel;
use Nilixin\Edu\debug\Debug;
use Nilixin\Edu\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, ".env.local");
$dotenv->load();

$router = new Router();

$router->get("/", [\Nilixin\Edu\Controller\HomeController::class, "index"])
       ->get("/user", [\Nilixin\Edu\Controller\UserController::class, "index"])
       ->get("/user/select", [\Nilixin\Edu\Controller\UserController::class, "select"])
       ->post("/user/show", [\Nilixin\Edu\Controller\UserController::class, "show"])
       ->get("/test", [\Nilixin\Edu\Controller\TestController::class, "submit"])
       ->post("/test/submit", [\Nilixin\Edu\Controller\TestController::class, "store"]);

// $router->register("/", function () {
//     echo "hello";
// });
// $router->register("/user", function () {
//     $user = new UserModel();
//     $user->selectOne("id = 101");
//     Debug::prn($user);
// });

session_start();

echo $router->resolve($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);




















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



// USER MODEL SHENANIGANS EXAMPLE
// Db::init();

// $user = new UserModel();

// $user->selectOne("id = 101");
// $user->login = "hello_world";
// $user->email = "hello@hel.hel";
// $user->password = "heeeeeeeeex";
// Debug::prn($user);
// $user->edit();