<?php

namespace Nilixin\Edu\controller;

use Nilixin\Edu\dto\UserDto;
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

    public function show()
    {
        $id = $_POST['id'];

        $userToShow = new UserModel();
        $userToShow->selectOne("id = $id");
        $userDto = UserDto::load($userToShow);

        return ViewHandler::make("view/user/userShowView.php", ['user' => $userDto])->layout("view/baseView.php");
    }
}