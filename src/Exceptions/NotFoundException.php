<?php

namespace Floky\Exceptions;

class NotFoundException extends \Exception
{

    public function __construct(string $msg, int $code)
    {
        parent::__construct($msg, $code);
    }
}
