<?php

namespace Nilixin\Edu\controllers;

use Nilixin\Edu\ViewHandler;
use Nilixin\Edu\requests\UserRequest;
use Nilixin\Edu\services\UserService;

class UserController
{
    public function fill()
    {
        return ViewHandler::make("views/user/userFillView.html")
            ->setLayout("views/baseView.html")
            ->setVariables(["error" => ""]);
    }

    public function submit()
    {
        $request = UserRequest::post();
        \Nilixin\Edu\debug\Debug::green($request);

        $message = UserService::addUser($request);
        \Nilixin\Edu\debug\Debug::green($message);
    }

    public function select()
    {
        return ViewHandler::make("views/user/userSelectView.html")
            ->setLayout("views/baseView.html");
    }

    public function demonstrate()
    {
        $request = UserRequest::post();

        // TODO убрать отсюда модель
        $model = new \Nilixin\Edu\models\UserModel;
        $user = $model->selectOne("id = $request->id");
        // \Nilixin\Edu\debug\Debug::val((object) $user);

        // TODO убрать костыль с конвертацией в объект, обрабатывать как массив в ViewHandler
        return ViewHandler::make("views/user/userShowView.html")
            ->setLayout("views/baseView.html")
            ->setVariables(["user" => (object) $user]);
    }
}