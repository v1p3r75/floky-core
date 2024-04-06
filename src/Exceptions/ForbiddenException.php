<?php

namespace Floky\Exceptions;

class ForbiddenException extends \Exception
{

    public function __construct(string $msg, int $code = Code::FORBIDDEN)
    {
        parent::__construct($msg, $code);
    }
}
