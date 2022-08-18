<?php

namespace Nilixin\Edu\debug;

class Debug
{
    public static function green($content)
    {
        echo '<pre style="background: palegreen; font-family: monospace; font-weight: bold; border: 1px solid black; padding: 2px">';
        print_r($content);
        echo '</pre>';
    }

    public static function blue($content)
    {
        echo '<pre style="background: navy; font-family: monospace; font-weight: bold; border: 1px solid black; padding: 2px">';
        print_r($content);
        echo '</pre>';
    }

    public static function yellow($content)
    {
        echo '<pre style="background: palegoldenrod; font-family: monospace; font-weight: bold; border: 1px solid black; padding: 2px">';
        print_r($content);
        echo '</pre>';
    }

    public static function gray($content)
    {
        echo '<pre style="background: darkgray; font-family: monospace; font-weight: bold; border: 1px solid black; padding: 2px">';
        print_r($content);
        echo '</pre>';
    }

    public static function prn($content)
    {
        echo '<pre style="background: darkgray; font-family: monospace; font-weight: bold; border: 1px solid black; padding: 2px">';
        print_r($content);
        echo '</pre>';
    }

    public static function dd($content)
    {
        echo '<pre style="background: darkred; font-family: monospace; font-weight: bold; border: 1px solid black; padding: 2px">';
        print_r($content);
        echo '</pre>';
        die();
    }
}