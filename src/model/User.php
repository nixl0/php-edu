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
        
    }

    // private function isFilled()
    // {
    //     if ($this->login === null || trim($this->login) === '') {
    //         return false;
    //     }
    //     if ($this->email === null || trim($this->email) === '') {
    //         return false;
    //     }
    //     if ($this->password === null || trim($this->password) === '') {
    //         return false;
    //     }

    //     return true;
    // }

    // public function edit()
    // {
    //     if ($this->isFilled()) {
    //         Db::update($this->table(), ["login" => "'$this->login'", "email" => "'$this->email'", "password" => "'$this->password'"], "id = $this->id");
    //     }
    // }
}