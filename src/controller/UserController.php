<?php

namespace Nilixin\Edu\controller;

use Nilixin\Edu\dto\UserDto;
use Nilixin\Edu\services\UserService;
use Nilixin\Edu\ViewHandler;
use Nilixin\Edu\model\UserModel;

class UserController
{
    public function index()
    {
        echo "<h1>User</h1>";
    }

    public function select()
    {
        return ViewHandler::make("view/user/userSelectView.php");
    }

    public function create(){
        $userDto = UserDto::load([
            'login' => 'dima',
            'email' => 'dima@mail.ru',
            'password' => '123211111'
        ]);

        $userService = new UserService();
        $user = $userService->create($userDto);

        return ViewHandler::make("view/user/userShowView.php", [
            'login' => $user->login,
            'email' => $user->email,
            'password' => $user->password,
        ])->layout("view/baseView.php");
    }

    public function show()
    {
        $id = $_GET['id'];

        $userService = new UserService();
        $user = $userService->getOne($id);

        // $userDto = UserDto::load($userToShow);

        // return ViewHandler::make("view/user/userShowView.php", ['user' => $userDto])->layout("view/baseView.php"); // TODO добавить поддержку передачи объектов
        return ViewHandler::make("view/user/userShowView.php", [
            'login' => $user->login,
            'email' => $user->email,
            'password' => $user->password,
        ])->layout("view/baseView.php");
    }
}