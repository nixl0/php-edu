<?php

namespace Nilixin\Edu\model;

use Nilixin\Edu\db\Db;
use Nilixin\Edu\db\SoftDelete;
use Nilixin\Edu\db\Model;

/**
 * Model User.
 * 
 * @author nilixin <nilixen@yandex.ru>
 * @version 1.0
 */
class User extends Model
{
    use SoftDelete;

    protected $id;
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

    /**
     * Checks if all of the properties are present and are full.
     * If they are, then returns true.
     * // TODO proper validation
     */
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

    /**
     * Returns the object of the class that satisfies the set where condition.
     * 
     * @param string $where Where condition.
     * @return User Instance of the class User.
     */
    public function get($where)
    {
        $table = $this->table();
        $res = Db::sql("SELECT * FROM $table WHERE $where")->one();
        $this->{$this->key()} = $res->{$this->key()};
        
        foreach ($this->fields() as $field) {
            $this->{$field} = $res->{$field};
        }

        if ($this->isFilled()) {
            return $this;
        }
    }

    /**
     * Adds user if the properties are present and filled.
     */
    public function add()
    {
        if ($this->isFilled()) {
            Db::insert($this->table, implode(", ", $this->fields), "'$this->login', '$this->email', '$this->password'");
        }
    }

    /**
     * Edits user if the properties are present and filled.
     */
    public function edit()
    {
        if ($this->isFilled()) {
            Db::update($this->table(), ["login" => "'$this->login'", "email" => "'$this->email'", "password" => "'$this->password'"], "id = $this->id");
        }
    }
}

?>