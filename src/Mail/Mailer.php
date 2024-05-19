<?php

namespace Floky\Mail;

class Mailer
{

    private array $config = [];

    public function __construct(protected MailerInterface $mailer) { }

    public function setDebugLevel(int $level) {

        $this->mailer->setDebugLevel($level);
        return $this;
    }
    
    public function isHtml(bool $value) {

        $this->mailer->isHTML($value);
        return $this;
    }

    public function from(string $from) {

        $this->mailer->from($from);
        return $this;
    }

    public function altBody(string $altBody) {

        $this->mailer->altBody($altBody);
        return $this;
    }

    public function attachement(string $path) {

        $this->mailer->attachement($path);
        return $this;
    }

    public function replyTo(string $address) {

        $this->mailer->replyTo($address);
        return $this;
    }

    public function sendMail(array $recipients, string $subject, string $body, bool $addCC = false) {

        return $this->mailer->sendMail($recipients, $subject, $body, $addCC);

    }

}