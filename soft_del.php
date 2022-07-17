<?php

trait SoftDelete
{
    public static function delete($conn, $table, $where)
    {
        $conn->query("UPDATE $table SET deleted_at = now() WHERE $where");
    }
}

?>