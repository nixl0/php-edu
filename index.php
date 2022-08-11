<?php

require_once "vendor/autoload.php";

error_reporting(-1);
ini_set("display_errors", 1);

use Nilixin\Edu\db\Db;
use Nilixin\Edu\models\UserModel;
use Nilixin\Edu\debug\Debug;
use Nilixin\Edu\Router;
use Nilixin\Edu\services\UserService;
use Nilixin\Edu\dtos\UserDto;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, ".env.local");
$dotenv->load();

session_start();

$router = new Router();

$router
    ->group(['prefix' => ''])
        ->get('/', [\Nilixin\Edu\controllers\HomeController::class, 'index'])
    ->group(['prefix' => '/user'])
        ->get('/add', [\Nilixin\Edu\controllers\UserController::class, 'fill'])
        ->post('/add', [\Nilixin\Edu\controllers\UserController::class, 'add'])
        ->get('/showall', [\Nilixin\Edu\controllers\UserController::class, 'showAll'])
        ->get('/showone', [\Nilixin\Edu\controllers\UserController::class, 'showOne']);;

echo $router->resolve($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);






// ----------------------------------------------
// Редактирование записи
// ----------------------------------------------

$model = new UserModel;
$service = UserService::init($model);
$entry = $service->selectOne("login = 'kabachok'");


$dto = $model->pop(new UserDto, $entry);
Debug::val($dto);

$dto = $model->edit($dto, [
    'email' => 'baklazhan'
]);
Debug::val($dto);

$status = $service->edit($dto);
Debug::val($status);