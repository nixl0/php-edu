<?php

namespace Nilixin\Edu\model;

use Nilixin\Edu\db\Db;
use Nilixin\Edu\db\SoftDelete;
use Nilixin\Edu\db\Model;

class User extends Model
{
    use SoftDelete;
    
    protected $login;
    protected $email;
    protected $password;

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
            if (! preg_match("/^[a-zA-Z-']*$/", $this->login)) {
                return false;
            }

            if (! filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }

            return true;
        }
    }
}