<?php

namespace Nilixin\Edu\validation;

use Nilixin\Edu\debug\Debug;
use Nilixin\Edu\exception\InvalidCredentialsException;
use Nilixin\Edu\ValidationInterface;

class UserValidation implements ValidationInterface
{
    public static function check($value, $details)
    {
        switch ($details["type"]) { // type
            case "id":
                if(!self::nSize($value, $details["min"], $details["max"])) {
                    throw new InvalidCredentialsException("User ID is out of size");
                    return false;
                }
                return true;

            case "login":
                if (! self::regexPlain($value)){
                    if (! self::size($value, $details["min"], $details["max"])) {
                        throw new InvalidCredentialsException("Invalid size");
                    }
                    throw new InvalidCredentialsException("Invalid regex plain");
                }
                break;

            case "email":
                if (! self::filterEmail($value)) {
                    throw new InvalidCredentialsException("Invalid email");
                }
                break;

            case "password":
                if (! self::size($value, $details["min"], $details["max"])) {
                    throw new InvalidCredentialsException("Invalid size");
                }
                break;
            
            default:
                throw new InvalidCredentialsException("Bad validation check");
                break;
        }
    }

    private static function regexPlain($input)
    {
        if (preg_match("/^[0-9a-zA-Z_]*$/", $input)) {
            return true;
        }
        else {
            return false;
        }
    }

    private static function size($input, $min, $max)
    {
        if (strlen($input) > $min && strlen($input) < $max) {
            return true;
        }
        else {
            return false;
        }
    }

    private static function nSize(int $input, int $min, int $max)
    {
        return $input > $min && $input < $max;
    }
    
    private static function filterEmail($input)
    {
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        else {
            return false;
        }
    }
}