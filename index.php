<?php

require_once "vendor/autoload.php";

error_reporting(-1);
ini_set("display_errors", 1);

use Nilixin\Edu\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, ".env.local");
$dotenv->load();

session_start();

$router = new Router();

$router
    ->group(["prefix" => ""])
        ->get("/", [\Nilixin\Edu\controllers\HomeController::class, "index"])
    ->group(["prefix" => "/user"])
        ->get("/add", [\Nilixin\Edu\controllers\UserController::class, "fill"])
        ->post("/add", [\Nilixin\Edu\controllers\UserController::class, "submit"])
        ->get("/show", [\Nilixin\Edu\controllers\UserController::class, "select"])
        ->post("/show", [\Nilixin\Edu\controllers\UserController::class, "demonstrate"]);

echo $router->resolve($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);



// $model = new \Nilixin\Edu\models\UserModel;
// $user = $model->selectOne("id = 24");
// \Nilixin\Edu\debug\Debug::green($user);

// $user->username = "username_changed";
// \Nilixin\Edu\debug\Debug::green($user);

// $message = $model->edit($user);
// \Nilixin\Edu\debug\Debug::green($message);



// $model = new \Nilixin\Edu\models\UserModel;
// $users = $model->selectAll("id < 24");
// \Nilixin\Edu\debug\Debug::green($users);