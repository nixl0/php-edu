<?php

namespace Nilixin\Edu\model;

use Nilixin\Edu\db\Db1;
use Nilixin\Edu\db\Model;
use Nilixin\Edu\db\ModelInterface;

class User extends Model implements ModelInterface
{

    protected $login;
    protected $email;
    protected $password;

    public function dbo()
    {
        return Db1::init();
    }

    public function table(): string
    {
        return "user";
    }

    public function fields(): array
    {
        return ["login", "email", "password"];
    }

    public function rules()
    {
        return [
            'login' => [
                'type' => 'login', 'min' => 3, 'max' => 15,
            ]
        ];
    }

    public function validate()
    {
        if ($this->validateBasic()) {
            if (!preg_match("/^[0-9a-zA-Z-'_]*$/", $this->login)) {
                return false;
            }

            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }

            if (strlen($this->password) < 6) {
                return false;
            }

            return true;
        }
    }
}