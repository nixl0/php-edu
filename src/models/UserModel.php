<?php

namespace Nilixin\Edu\models;

use Nilixin\Edu\validations\UserValidation;

class UserModel extends Model
{
    public function table()
    {
        return "users";
    }

    public function validator()
    {
        return UserValidation::class;
    }

    public function rules()
    {
        return [
            "username" => [
                "rule" => "plain",
                "min" => 3,
                "max" => 64
            ],
            "password" => [
                "min" => 6,
                "max" => 128
            ],
            "email" => [
                "rule" => "email"
            ]
        ];
    }
}
