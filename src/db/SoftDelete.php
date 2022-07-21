<?php

namespace Nilixin\Edu\db;

trait SoftDelete
{
    
    public static function delete($table)
    {
        $db = self::init();

        $db->query = "UPDATE $table SET deleted_at = now()";

        return $db;
    }
    
}