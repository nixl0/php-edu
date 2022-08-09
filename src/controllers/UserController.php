<?php

namespace Nilixin\Edu\controllers;

use Nilixin\Edu\ViewHandler;
use Nilixin\Edu\dtos\UserDto;
use Nilixin\Edu\models\UserModel;
use Nilixin\Edu\services\UserService;

class UserController
{
    public function index()
    {
        echo "<h1>User</h1>";
    }

    public function select()
    {
        return ViewHandler::make("views/user/userSelectView.html")
                          ->setLayout("views/baseView.html");
    }

    public function create()
    {
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
        ])->setLayout("view/baseView.php");
    }

    public function show()
    {
        // $id = $_POST['id'];
        $id = $_GET['id'];

        // $userToShow = new UserModel();
        // $userToShow->selectOne("id = $id");
        // $userDto = UserDto::load($userToShow);
        $userService = new UserService();
        $user = $userService->getOne($id);

        // return ViewHandler::make("view/user/userShowView.html", ['user' => $userDto])->layout("view/baseView.html"); // TODO добавить поддержку передачи объектов
        // return ViewHandler::make("view/user/userShowView.html")
        //                   ->setVariables([
        //                     'login' => $userToShow->login,
        //                     'email' => $userToShow->email,
        //                     'password' => $userToShow->password
        //                   ])
        //                   ->setLayout("view/baseView.html");

        return ViewHandler::make("views/user/userShowView.html")
                          ->setVariables(['user' => $user])
                          ->setLayout("views/baseView.html");
    }
}