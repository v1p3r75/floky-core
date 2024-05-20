<?php

namespace Floky\Mail;

interface MailerInterface
{

    public function setDebugLevel(int $level);
    
    public function isHtml(bool $value);

    public function from(string $from);

    public function altBody(string $altBody);

    public function attachement(string $path);

    public function replyTo(string $address);

    public function sendMail(array $recipients, string $subject, string $body, bool $addCC = false);


}