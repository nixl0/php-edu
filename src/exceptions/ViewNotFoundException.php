<?php

namespace Nilixin\Edu\exceptions;

use Exception;

class ViewNotFoundException extends Exception
{ 
    protected $message = "View not found";
}