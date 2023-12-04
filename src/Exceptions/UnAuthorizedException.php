<?php

namespace Floky\Exceptions;

class UnAuthorizedException extends \Exception
{

    public function __construct(string $msg, int $code = Code::UNAUTHORIZED)
    {
        parent::__construct($msg, $code);
    }
}
