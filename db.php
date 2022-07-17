<?php

class Db
{
    private static $instance = null;
    private $conn;
  
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

        $this->conn = new PDO("pgsql:host=$this->host;dbname=$this->dbname", "$this->username", "$this->password");
    }
    
    public static function getInstance($host, $dbname, $username, $password)
    {
        if(!self::$instance)
        {
            self::$instance = new Db($host, $dbname, $username, $password);
        }
    
        return self::$instance;
    }
    
    public function getConnection()
    {
        return $this->conn;
    }

}

?>