<?php

namespace Nilixin\Edu\db;

use Exception;
use PDO;

class Db
{
    private static $instance = null;

    protected static $conn;
    
    private $host, $dbname, $username, $password, $dbDriver;
    private $pdoStatement, $query;
    
    private function __construct()
    {
        $this->host = $_ENV["DB_HOST"];
        $this->dbname = $_ENV["DB_NAME"];
        $this->username = $_ENV["DB_USER"];
        $this->password = $_ENV["DB_PASS"];
        $this->dbDriver = $_ENV["DB_DRIVER"];

        try {
            self::$conn = new PDO("$this->dbDriver:host=$this->host;dbname=$this->dbname", "$this->username", "$this->password");
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
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

        $db->query = "UPDATE $table SET $data";

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

    public function fetchAll()
    {
        try {
            $this->pdoStatement = self::$conn->prepare($this->query); // TODO prepared statements написаны неправильно
            $this->pdoStatement->execute();

            return $this->pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable) {
            throw new Exception('Unable to execute PDO statement');
        }
    }

    public function fetch()
    {
        try {
            $this->pdoStatement = self::$conn->prepare($this->query);
            $this->pdoStatement->execute();

            return $this->pdoStatement->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable) {
            throw new Exception('Unable to execute PDO statement');
        }
    }

    public function execute()
    {
        try {
            $this->pdoStatement = self::$conn->prepare($this->query);
            return $this->pdoStatement->execute();
        } catch (\Throwable) {
            throw new Exception('Unable to execute PDO statement');
        }
    }

    public function getQuery()
    {
        return $this->query;
    }

}