<?php

namespace Nilixin\Edu\debug;

class Debug
{
    public static function prn($content)
    {
        echo '<pre style="background: palegreen; font-family: monospace; font-weight: bold; border: 1px solid black; padding: 2px">';
        print_r($content);
        echo '</pre>';
    }

    public static function dd($content)
    {
        echo '<pre style="background: palegreen; font-family: monospace; font-weight: bold; border: 1px solid black; padding: 2px">';
        print_r($content);
        echo '</pre>';
        die();
    }
}