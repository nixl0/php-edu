<?php

namespace Nilixin\Edu\controllers;

use Nilixin\Edu\debug\Debug;
use Nilixin\Edu\dtos\UserDto;
use Nilixin\Edu\models\UserModel;
use Nilixin\Edu\ViewHandler;

class HomeController
{
    public function index()
    {
        return ViewHandler::make("views/homeView.html")
                          ->setVariables(["hello" => "world"])
                          ->setLayout("views/baseView.html");
    }

    public function other()
    {
        return ViewHandler::make("views/homeView.html")
                          ->setVariables(["hello" => "other"])
                          ->setLayout("views/baseView.html");
    }
}