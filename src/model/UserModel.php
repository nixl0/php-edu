<?php

namespace Nilixin\Edu\model;

use Nilixin\Edu\Model;
use Nilixin\Edu\db\Db;
use Nilixin\Edu\db\SoftDelete;
use Nilixin\Edu\validation\UserValidation;

class UserModel extends Model
{
    use SoftDelete;

    protected $login;
    protected $email;
    protected $password;

    public function table(): string
    {
        return "user";
    }

    public function fields(): array
    {
        return ["login", "email", "password"];
    }

    public function validator()
    {
        return UserValidation::class;
    }

    public static function getUserMaxID($alias = 'max') {
        $maxId = Db::select("MAX(id) as ".$alias)
            ->from("user")
            ->fetch();
        return $maxId[$alias];
    }

    public function rules()
    {
        return [
            "login" => [
                "type" => "login",
                "min" => 3,
                "max" => 64
            ],
            "email" => [
                "type" => "email"
            ],
            "password" => [
                "type" => "password",
                "min" => 6,
                "max" => 128
            ]
        ];
    }
}