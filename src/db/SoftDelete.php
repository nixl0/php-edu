<?php

namespace Nilixin\Edu\db;

trait SoftDelete
{
    
    public function delete()
    {
        $id = $this->{$this->key()};
        
        $this->dbo()::update($this->table(), "deleted_at = now()")
             ->where("id = $id")
             ->getStatement();
    }
    
}