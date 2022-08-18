<?php

namespace Nilixin\Edu\services;

use Nilixin\Edu\models\UserModel;

class UserService
{
    public static function addUser($dto)
    {
        $model = new UserModel;
        $message = $model->add($dto);

        return $message;
    }
}
