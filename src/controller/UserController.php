<?php

namespace Nilixin\Edu\controller;

use Nilixin\Edu\ViewHandler;
use Nilixin\Edu\validation\UserValidation;
use Nilixin\Edu\model\UserModel;

class UserController
{
    public function index()
    {
        echo "<h1>User</h1>";
    }

    public function select()
    {
        return ViewHandler::make("view/user/userSelectView.php")->layout('view/baseView.php');
    }

    public function show()
    {
        $validation = UserValidation::class;

        $id = (int) $_POST['id'];

        $maxId = UserModel::getUserMaxID();
        $checkId = $validation::check(
            $id, [
                'type' => 'id',
                'min' => 0,
                'max' => $maxId + 1
            ]
        );

        if(!$checkId) return;

        $userToShow = new UserModel();
        $userToShow->selectOne("id = $id");

        return ViewHandler::make("view/user/userShowView.php", [
            "login" => "$userToShow->login",
            "email" => "$userToShow->email"
        ]);
    }
}