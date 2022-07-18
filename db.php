<?php

class Db
{
    private static $instance = null;
    protected static $conn;
  
    private $host = 'localhost';
    private $dbname = 'dbname';
    private $username = 'username';
    private $password = 'password';
    
    private function __construct($host, $dbname, $username, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;

        self::$conn = new PDO("pgsql:host=$this->host;dbname=$this->dbname", "$this->username", "$this->password");
    }
    
    public static function getInstance($host, $dbname, $username, $password)
    {
        if (! self::$instance) {
            self::$instance = new Db($host, $dbname, $username, $password);
        }
    
        return self::$instance;
    }

    public static function sql($sql)
    {
        return self::$conn->query($sql)->fetchColumn(0);
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

?>