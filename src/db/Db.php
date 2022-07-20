<?php

namespace Nilixin\Edu\db;

use PDO;

class Db
{
    private static $instance = null;

    protected static $conn;
    
    private $host, $dbname, $username, $password;
    private $pdoStatement, $query;
    
    private function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->dbname = $_ENV['DB_DATABASE'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];

        self::$conn = new PDO("pgsql:host=$this->host;dbname=$this->dbname", "$this->username", "$this->password");
    }
    
    public static function init()
    {
        if (! self::$instance) {
            self::$instance = new Db();
        }
    
        return self::$instance;
    }

    public static function select($expression)
    {
        $db = self::init();
        $db->query = "SELECT $expression";
        return $db;
    }

    public static function insert($table, $attrs, $vals)
    {
        $db = self::init();
        $db->query = "INSERT INTO $table ($attrs) VALUES ($vals)";
        return $db;
    }

    public static function update($table, $data)
    {
        $db = self::init();

        $db->query = "UPDATE $table SET ";

        $moreThanOne = false;
        foreach ($data as $attr => $value) {
            if ($moreThanOne) {
                $db->query .= ", $attr = $value";
            }
            else {
                $db->query .= "$attr = $value";
                $moreThanOne = true;
            }
        }

        return $db;
    }

    public static function delete($table)
    {
        $db = self::init();

        $db->query = "DELETE FROM $table";

        return $db;
    }

    public static function from($table)
    {
        $db = self::init();
        $db->query .= " FROM $table";
        return $db;
    }

    public static function where($condition)
    {
        $db = self::init();
        $db->query .= " WHERE $condition";
        return $db;
    }

    public function getObject()
    {
        $this->pdoStatement = self::$conn->query($this->query);

        return $this->pdoStatement->fetchObject();
    }

    public function getStatement()
    {
        $this->pdoStatement = self::$conn->query($this->query);

        return $this->pdoStatement;
    }

}