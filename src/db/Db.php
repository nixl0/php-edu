<?php

namespace Nilixin\Edu\db;

use PDO;

class Db
{
    private static $instance = null;

    protected static $conn;
    
    private $host, $dbname, $username, $password;
    private $pdoStatement;
    
    private function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->dbname = $_ENV['DB_DATABASE'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];

        self::$conn = new PDO("pgsql:host=$this->host;dbname=$this->dbname", "$this->username", "$this->password");
    }
    
    public static function initialize()
    {
        if (! self::$instance) {
            self::$instance = new Db();
        }
    
        return self::$instance;
    }
    
    public static function sql($sql)
    {
        $obj = self::initialize();
        $obj->pdoStatement = self::$conn->query($sql);
        return $obj;
    }

    public function one()
    {
        return $this->pdoStatement->fetchObject();
    }

    public static function read($table)
    {
        $result = self::$conn->query("SELECT * FROM {$table}");
        return $result;
    }

    public static function update($table, $data, $where)
    {
        $sql = "UPDATE $table SET ";

        $moreThanOne = false;
        foreach ($data as $attr => $value) {
            if ($moreThanOne) {
                $sql .= ", $attr = $value";
            }
            else {
                $sql .= "$attr = $value";
                $moreThanOne = true;
            }
        }

        $sql .= "WHERE $where";

        self::$conn->query($sql);
    }

    public static function insert($table, $attrs, $values)
    {
        self::$conn->query("INSERT INTO $table ($attrs) values ($values)");
    }
    
    public static function delete($table, $where)
    {
        self::$conn->query("DELETE FROM $table WHERE $where");
    }

}