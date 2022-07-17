<?php

class Sql
{
    public static function read($conn, $table)
    {
        $result = $conn->query("SELECT * FROM {$table}");
        return $result;
    }

    public static function update($conn, $table, $attr, $value, $where)
    {
        $conn->query("UPDATE $table SET $attr = '$value' WHERE $where");
    }

    public static function insert($conn, $table, $attrs, $values)
    {
        $conn->query("INSERT INTO $table ($attrs) values ($values)");
    }

    public static function delete($conn, $table, $where)
    {
        $conn->query("DELETE FROM $table WHERE $where");
    }
}

?>