<?php

namespace Nilixin\Edu\controllers;

use Nilixin\Edu\debug\Debug;
use Nilixin\Edu\ViewHandler;
use Nilixin\Edu\dtos\UserDto;
use Nilixin\Edu\models\UserModel;
use Nilixin\Edu\services\UserService;
use Nilixin\Edu\requests\UserRequest;

class UserController
{
    public function fill()
    {
        return ViewHandler::make('views/user/userAddView.html')
            ->setLayout('views/baseView.html')
            ->setVariables(['error' => '']);
    }

    public function add()
    {
        $user = UserRequest::post(new UserDto);

        $service = UserService::init(new UserModel);

        $status = $service->add($user);
        Debug::val($status); // TODO в зависимости от статуса отображать то или иное представление
    }

    // выводит все записи, удовлетворяющие указанному условию
    public function showAll()
    {
        $model = new UserModel;
        $service = UserService::init($model);
        $entries = $service->selectAll('id < 20');

        $dtos = array();
        foreach ($entries as $entry) {
            $dto = $model->pop(new UserDto, $entry);
            array_push($dtos, $dto);
        }

        Debug::val($dtos);
    }

    // выводит одну запись
    public function showOne()
    {
        $model = new UserModel;
        $service = UserService::init($model);
        $entry = $service->selectOne("login = 'yanik'");

        $dto = $model->pop(new UserDto, $entry);

        Debug::val($dto);
    }
}