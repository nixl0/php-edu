<?php

namespace Nilixin\Edu\validation;

use BadMethodCallException;
use Nilixin\Edu\debug\Debug;
use Nilixin\Edu\exception\InvalidCredentialsException;

class BaseValidation
{
    public static function check($value, $details)
    {
        foreach ($details as $key => $detail) {
            switch ($key) {
                case "checkif":
                    // проверка существует ли указанный метод в данном классе или в классе наследнике
                    if (! method_exists(static::class, $detail) &&
                        ! method_exists(self::class, $detail)) {
                        throw new BadMethodCallException("No such method defined");
                    }

                    // вызов метода проверки
                    if (! static::$detail($value)) {
                        throw new InvalidCredentialsException("Invalid check-if");
                    }
                    break;
                
                case "min":
                    if (! self::min($value, $detail)) {
                        throw new InvalidCredentialsException("Size too big");
                    }
                    break;

                case "max":
                    if (! self::max($value, $detail)) {
                        throw new InvalidCredentialsException("Size too small");
                    }
                    break;
                
                default:
                    throw new BadMethodCallException("Validation parameter not found");
                    break;
            }
        }
    }

    private static function plain($input)
    {
        if (preg_match("/^[0-9a-zA-Z_]*$/", $input)) {
            return true;
        }
        else {
            return false;
        }
    }

    private static function min($input, $min)
    {
        if (strlen($input) > $min) {
            return true;
        }
        else {
            return false;
        }
    }

    private static function max($input, $max)
    {
        if (strlen($input) < $max) {
            return true;
        }
        else {
            return false;
        }
    }
}