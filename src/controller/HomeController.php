<?php

namespace Nilixin\Edu\controller;

use Nilixin\Edu\debug\Debug;
use Nilixin\Edu\dto\UserDto;
use Nilixin\Edu\model\UserModel;
use Nilixin\Edu\ViewHandler;

class HomeController
{
    public function index()
    {
        $user = new UserModel();
        $user->selectOne("id = 1");
        $userDto = UserDto::load($user);

        return ViewHandler::make("view/homeView.php", ['user' => $userDto])->layout("view/baseView.php");
    }

    public function other()
    {
        return ViewHandler::make("view/homeView.php", ["hello" => "other"])->layout("view/baseView.php");
    }
}