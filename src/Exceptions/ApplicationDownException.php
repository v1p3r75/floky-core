<?php

namespace Floky\Exceptions;

class ApplicationDownException extends \Exception
{

    public function __construct(string $msg, int $code = Code::APP_DOWN)
    {
        parent::__construct($msg, $code);
    }
}
