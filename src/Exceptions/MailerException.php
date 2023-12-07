<?php

namespace Floky\Exceptions;

class MailerException extends \Exception
{

    public function __construct(string $msg, int $code = Code::MAILER)
    {
        parent::__construct($msg, $code);
    }
}
