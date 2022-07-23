<?php

namespace Nilixin\Edu\exception;

use Exception;

class ViewNotFoundException extends Exception
{ 
    protected $message = "View not found";
}