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
        return ViewHandler::make("view/homeView.php")
                          ->setVariables(["hello" => "world"])
                          ->setLayout("view/baseView.php");
    }

    public function other()
    {
        return ViewHandler::make("view/homeView.php", ["hello" => "other"])->setLayout("view/baseView.php");
    }
}