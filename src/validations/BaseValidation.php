<?php

namespace Nilixin\Edu\validations;

use BadMethodCallException;
use Exception;
use Nilixin\Edu\debug\Debug;
use Nilixin\Edu\exceptions\InvalidCredentialsException;

class BaseValidation
{
    public static function check($value, $details)
    {
        foreach ($details as $attr => $detail) {
            $methodExists = false;

            // если значение указанное в АТРИБУТЕ ($attr) это метод
            if (method_exists(static::class, $attr) ||
                method_exists(self::class, $attr)) {
                $methodExists = true;
                if (!static::$attr($value, $detail))
                    throw new InvalidCredentialsException("Invalid validation method ($attr)");
            }

            // если значение указанное в ЗНАЧЕНИИ ($detail) это метод
            if (method_exists(static::class, $detail) ||
                method_exists(self::class, $detail)) {
                $methodExists = true;
                if (!static::$detail($value))
                    throw new InvalidCredentialsException("Invalid validation method ($detail)");
            }

            // исключение, если метод валидации так и не был найден
            if (! $methodExists) {
                throw new BadMethodCallException("Validation method not found ($attr)");
            }
        }
    }

    private static function plain($input)
    {
        if (preg_match("/^[0-9a-zA-Z_]*$/", $input)) {
            return true;
        }
        else {
            throw new InvalidCredentialsException("Text contains unsupported characters");
        }
    }

    private static function min($input, $min)
    {
        if (strlen($input) > $min) {
            return true;
        }
        else {
            throw new InvalidCredentialsException("Value too small");
        }
    }

    private static function max($input, $max)
    {
        if (strlen($input) < $max) {
            return true;
        }
        else {
            throw new InvalidCredentialsException("Value too big");
        }
    }
}