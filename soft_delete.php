<?php

trait SoftDelete
{
    public function deleteFrom($table)
    {
        $this->sql = "UPDATE $table SET deleted_at = now()";
        return $this;
    }
}

?>