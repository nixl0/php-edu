<?php

namespace Nilixin\Edu\db;

trait SoftDelete
{
    
    public static function delete($table, $where)
    {
        parent::$conn->query("UPDATE $table SET deleted_at = now() WHERE $where");
    }
    
}