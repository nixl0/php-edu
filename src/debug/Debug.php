<?php

namespace Nilixin\Edu\debug;

class Debug
{
    public static function prn($content)
    {
        echo '<pre class="debug-prn">';
        print_r($content);
        echo '</pre>';
    }

    public static function dd($content)
    {
        echo '<pre class="debug-dd">';
        print_r($content);
        echo '</pre>';
        die();
    }
}