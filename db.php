<?php

class Db
{
    private static $instance = null;
    private $conn;
  
    private $host = 'localhost';
    private $dbname = 'dbname';
    private $username = 'username';
    private $password = 'password';

    protected $sql;
    
    private function __construct($host, $dbname, $username, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;

        $this->conn = new PDO("pgsql:host=$this->host;dbname=$this->dbname", "$this->username", "$this->password");
    }
    
    // getInstance
    public static function authorize($host, $dbname, $username, $password)
    {
        if(!self::$instance) {
            self::$instance = new Db($host, $dbname, $username, $password);
        }
    
        return self::$instance;
    }

    // get
    public static function query()
    {
        if(self::$instance) {
            return self::$instance;
        }
    }

    public function select($expression, $table)
    {
        $this->sql = "SELECT $expression FROM $table";
        return $this;
    }

    public function insertInto($table, $attrs, $values)
    {
        $this->sql = "INSERT INTO $table ($attrs) VALUES ($values)";
        return $this;
    }

    public function update($table, $data)
    {
        $this->sql = "UPDATE $table SET ";
        
        $moreThanOne = false;
        foreach ($data as $attr => $value) {
            if ($moreThanOne) {
                $this->sql .= ", " . "$attr = $value";
            }
            else {
                $this->sql .= "$attr = $value";
            }
        }
        
        return $this;
    }

    public function deleteFrom($table)
    {
        $this->sql = "DELETE FROM $table";
        return $this;
    }

    public function where($condition)
    {
        $this->sql .= " WHERE $condition";
        return $this;
    }

    public function orderBy($sortExpression)
    {
        $this->sql .= " ORDER BY $sortExpression";
        return $this;
    }

    public function getSql()
    {
        return $this->sql;
    }

    public function execute()
    {
        $result = $this->conn->query($this->sql);
        return $result;
    }

}

?>