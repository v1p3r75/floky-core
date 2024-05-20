<?php

namespace Floky\Facades;

use Floky\Mail\Mailer as MailMailer;

/**
 * @method static mixed setDebugLevel(int $level)
 * @method static mixed isHtml(bool $value)
 * @method static mixed from(string $from)
 * @method static mixed altBody(string $altBody)
 * @method static mixed attachement(string $path)
 * @method static mixed replyTo(string $address)
 * @method static mixed sendMail(array $recipients, string $subject, string $body, bool $addCC = false)
 */
class Mailer extends Facade

{

    protected static function getTargetClass(): string
    {
        return MailMailer::class;
    }

}