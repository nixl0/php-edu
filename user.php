<?php

class User
{
    private $id;
    private $login;
    private $email;
    private $password;

    public function construct($login, $email, $password)
    {
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
    }

    public function constructWithId($id, $login, $email, $password)
    {
        $new_user = new User($login, $email, $password);
        $new_user->id = $id;
        return $new_user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    private function isFilled()
    {
        if ($this->login === null || trim($this->login) === '') {
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

    public function get($where)
    {
        $this->id = Db::sql("SELECT id FROM users WHERE $where");
        $this->login = Db::sql("SELECT login FROM users WHERE $where");
        $this->email = Db::sql("SELECT email FROM users WHERE $where");
        $this->password = Db::sql("SELECT password FROM users WHERE $where");

        if ($this->isFilled()) {
            return $this;
        }
    }

    public function add()
    {
        if ($this->isFilled()) {
            Db::insert("users", "login, email, password", "'$this->login', '$this->email', '$this->password'");
        }
    }

    public function edit()
    {
        if ($this->isFilled()) {
            Db::update("users", ["login" => "'$this->login'", "email" => "'$this->email'", "password" => "'$this->password'"], "id = $this->id");
        }
    }
}

?>