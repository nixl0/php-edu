<?php

namespace Nilixin\Edu\controllers;

use Nilixin\Edu\ViewHandler;

class HomeController
{
    public function index()
    {
        return ViewHandler::make("views/homeView.html")
            ->setLayout("views/baseView.html");
    }
}