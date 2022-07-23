<?php

namespace Nilixin\Edu\Controller;

use Nilixin\Edu\ViewHandler;

class HomeController
{
    public function index()
    {
        return ViewHandler::make("view/HomeView.php", ["hello" => "world"]);
    }
}