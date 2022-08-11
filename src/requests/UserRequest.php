<?php

namespace Nilixin\Edu\requests;

use Nilixin\Edu\dtos\UserDto;
use Nilixin\Edu\models\UserModel;

class UserRequest
{
    public static function post(UserDto $dto)
    {
        if (! empty($_POST)) {
            foreach ($dto->fields()['necessary'] as $field) {
                $dto->$field = $_POST[$field];
            }
        }

        return $dto;
    }

    public static function get(UserDto $dto)
    {
        foreach ($dto->fields()['all'] as $field) {
            if (key_exists($field, $_GET)) {
                $dto->$field = $_POST[$field];
            }
        }

        return $dto;
    }
}
