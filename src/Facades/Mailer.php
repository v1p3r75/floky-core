<?php

namespace Floky\Facades;

use Floky\Mail\Mailer as MailMailer;

class Mailer extends Facade

{

    protected static function getTargetClass(): string
    {
        return MailMailer::class;
    }

}