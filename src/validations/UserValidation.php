<?php

namespace Nilixin\Edu\validations;

use Nilixin\Edu\exceptions\InvalidCredentialsException;

class UserValidation extends Validation
{
    protected static function email($input)
    {
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            throw new InvalidCredentialsException("Invalid email");
        }
    }
}