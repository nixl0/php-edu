<?php

namespace Nilixin\Edu\controllers;

use Nilixin\Edu\dtos\UserDto;
use Nilixin\Edu\ViewHandler;
use Nilixin\Edu\models\UserModel;

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

    public function show()
    {
        $id = $_POST['id'];

        $userToShow = new UserModel();
        $userToShow->selectOne("id = $id");
        $userDto = UserDto::load($userToShow);

        // return ViewHandler::make("view/user/userShowView.html", ['user' => $userDto])->layout("view/baseView.html"); // TODO добавить поддержку передачи объектов
        // return ViewHandler::make("view/user/userShowView.html")
        //                   ->setVariables([
        //                     'login' => $userToShow->login,
        //                     'email' => $userToShow->email,
        //                     'password' => $userToShow->password
        //                   ])
        //                   ->setLayout("view/baseView.html");

        return ViewHandler::make("views/user/userShowView.html")
                          ->setVariables(['user' => $userDto])
                          ->setLayout("views/baseView.html");
    }
}