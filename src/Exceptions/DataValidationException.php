<?php

namespace Floky\Exceptions;

use Exception;

class DataValidationException extends Exception 
{
    public function __construct(string $msg, int $code = Code::DATA_VALIDATION)
    {

        parent::__construct($msg, $code);
    }
}