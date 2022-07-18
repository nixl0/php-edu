<?php

class User
{
    private $id;
    private $username;
    private $email;
    private $password;

    public function __construct($username, $email, $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public static function constructWithId($id, $username, $email, $password)
    {
        $new_user = new User($username, $email, $password);
        $new_user->id = $id;
        return $new_user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    private function isFilled()
    {
        if ($this->username === null || trim($this->username) === '') {
            return false;
        }
        if ($this->email === null || trim($this->email) === '') {
            return false;
        }
        if ($this->password === null || trim($this->password) === '') {
            return false;
        }

        return true;
    }

    public function add()
    {
        if ($this->isFilled()) {
            Db::query()->insertInto("users", "login, email, password", "'$this->username', '$this->email', '$this->password'")->execute();
        }
    }

    public function edit()
    {
        if ($this->isFilled()) {
            Db::query()->update("users", ["login" => "'$this->username'", "email" => "'$this->email'", "password" => "'$this->password'"])->execute();
        }
    }
}

?>