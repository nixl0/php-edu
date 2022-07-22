<?php

namespace Nilixin\Edu\db;

use Nilixin\Edu\debug\Debug;

class Validation
{
    public static function regexPlain($input)
    {
        if (preg_match("/^[0-9a-zA-Z_]*$/", $input)) {
            return true;
        }
        else {
            return false;
        }
    }



    public static function size($input, $min, $max)
    {
        if (strlen($input) > $min && strlen($input) < $max) {
            return true;
        }
        else {
            return false;
        }
    }

    
    
    public static function filterEmail($input)
    {
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        else {
            return false;
        }
    }


}