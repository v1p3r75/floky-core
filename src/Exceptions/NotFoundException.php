<?php

namespace Floky\Exceptions;

class NotFoundException extends \Exception
{

    public function __construct($msg = "", $code) {

        parent::__construct($msg, $code);
    }
}