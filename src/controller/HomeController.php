<?php

namespace Nilixin\Edu\controller;

use Nilixin\Edu\ViewHandler;

class HomeController
{
    public function index()
    {
        return ViewHandler::make("view/homeView.php", ["hello" => "world"]);
    }

    public function other()
    {
        return ViewHandler::make("view/homeView.php", ["hello" => "other"]);
    }
}