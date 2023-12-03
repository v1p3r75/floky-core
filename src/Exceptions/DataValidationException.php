<?php

namespace Floky\Exceptions;

use Exception;

class DataValidationException extends Exception 
{
    public function __construct($msg = "", $code = 4003) {

        parent::__construct($msg, $code);
    }
}