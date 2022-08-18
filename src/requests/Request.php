<?php

namespace Nilixin\Edu\requests;

abstract class Request
{
    public static $instance;

    public abstract function fields();

    public static function init()
    {
        self::$instance ?? self::$instance = new static;
        return self::$instance;
    }

    public static function post()
    {
        if (empty($_POST)) return;

        foreach (self::init()->fields() as $field) {
            if (! key_exists($field, $_POST) or empty($_POST[$field])) continue;

            self::init()->$field = $_POST[$field];
        }

        return self::init();
    }
}
