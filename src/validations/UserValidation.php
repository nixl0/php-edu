<?php

namespace Nilixin\Edu\validations;

use Nilixin\Edu\debug\Debug;

class UserValidation extends BaseValidation
{
    protected static function email($input)
    {
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        else {
            return false;
        }
    }
}