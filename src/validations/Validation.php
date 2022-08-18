<?php

namespace Nilixin\Edu\validations;

use BadMethodCallException;
use Nilixin\Edu\exceptions\InvalidCredentialsException;

class Validation
{
    /**
     * Отменяет проверку валидации если не указаны свойства или правила валидации
     * Если свойства и правила валидации указаны, то сопоставляет правила
     * для конкретного свойства (детали) и передаёт проверяемое значение
     * и эти детали в метод проверки.
     */
    public static function validate($dto, $rules)
    {
        if (!$dto) return;
        if (!$rules) return;

        foreach ($dto as $property => $value) {
            foreach ($rules as $ruleProperty => $details) {
                if ($property == $ruleProperty) {
                    self::check($value, $details);
                }
            }
        }
    }

    /**
     * Метод проверки указанных значений с переданными правилами.
     */
    private static function check($value, $details)
    {
        foreach ($details as $attr => $detail) {
            $methodExists = false;

            // если значение указанное в АТРИБУТЕ ($attr) это метод
            if (
                method_exists(static::class, $attr) ||
                method_exists(self::class, $attr)
            ) {
                $methodExists = true;
                if (!static::$attr($value, $detail))
                    throw new InvalidCredentialsException("Invalid validation method ($attr)");
            }

            // если значение указанное в ЗНАЧЕНИИ ($detail) это метод
            if (
                method_exists(static::class, $detail) ||
                method_exists(self::class, $detail)
            ) {
                $methodExists = true;
                if (!static::$detail($value))
                    throw new InvalidCredentialsException("Invalid validation method ($detail)");
            }

            // исключение, если метод валидации так и не был найден
            if (!$methodExists) {
                throw new BadMethodCallException("Validation method not found ($attr)");
            }
        }
    }

    protected static function plain($input)
    {
        if (preg_match("/^[0-9a-zA-Z_]*$/", $input)) {
            return true;
        } else {
            throw new InvalidCredentialsException("Text contains unsupported characters");
        }
    }

    protected static function min($input, $min)
    {
        if (strlen($input) > $min) {
            return true;
        } else {
            throw new InvalidCredentialsException("Value too small");
        }
    }

    protected static function max($input, $max)
    {
        if (strlen($input) < $max) {
            return true;
        } else {
            throw new InvalidCredentialsException("Value too big");
        }
    }
}
