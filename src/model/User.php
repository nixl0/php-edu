<?php

namespace Nilixin\Edu\model;

use Nilixin\Edu\db\Db1;
use Nilixin\Edu\db\Model;

class User extends Model
{
    protected $login;
    protected $email;
    protected $password;

    public function dbo()
    {
        return Db1::init();
    }

    public function table()
    {
        return "users";
    }

    public function fields()
    {
        return ["login", "email", "password"];
    }

    public function validate()
    {
        if ($this->validateBasic()) {
            if (! preg_match("/^[0-9a-zA-Z-'_]*$/", $this->login)) {
                return false;
            }

            if (! filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }

            if (strlen($this->password) < 6) {
                return false;
            }

            return true;
        }
    }
}