<?php

namespace Nilixin\Edu\db;

abstract class Model
{
    public abstract function table();
    public abstract function fields();

    public function key()
    {
        return "id";
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }

    public abstract function get($where);

    public abstract function add();
    public abstract function edit();
}

?>