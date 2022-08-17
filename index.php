<?php

require_once "vendor/autoload.php";

error_reporting(-1);
ini_set("display_errors", 1);

use Nilixin\Edu\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, ".env.local");
$dotenv->load();

session_start();

$router = new Router();

$router->group(["prefix" => ""])
    ->get("/", [\Nilixin\Edu\controllers\HomeController::class, "index"]);


echo $router->resolve($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);