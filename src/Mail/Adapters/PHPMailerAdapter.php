<?php

namespace Floky\Mail\Adapters;

use Floky\Exceptions\MailerException;
use Floky\Facades\Config;
use Floky\Mail\MailerInterface;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception as PHPMailerException;


class PHPMailerAdapter implements MailerInterface {

    private array $config;

    public function __construct(private PHPMailer $mail) {

        $this->config = Config::get('mail');

        $this->mail->SMTPDebug = SMTP::DEBUG_OFF;                      
        $this->mail->isSMTP();                                            
        $this->mail->Host       = $this->config['host'];                    
        $this->mail->SMTPAuth   = true;                                   
        $this->mail->Username   = $this->config['username'];                     
        $this->mail->Password   = $this->config['password'];                               
        $this->mail->SMTPSecure = $this->config['encryption'];           
        $this->mail->Port       = $this->config['port'];

        //Recipients
        $this->mail->setFrom($this->config['from'], env('APP_NAME'));
    }
    public function setDebugLevel(int $level) {

        return $this->mail->SMTPDebug = $level;
    }
    
    public function isHtml(bool $value) {

        return $this->mail->isHTML($value);
    }

    public function from(string $from) {

        return $this->mail->setFrom($from);
    }

    public function altBody(string $altBody) {

        return $this->mail->AltBody = $altBody;
    }

    public function attachement(string $path) {

        return $this->mail->addAttachment($path);
    }

    public function replyTo(string $address) {

        return $this->mail->addReplyTo($address);
    }

    public function sendMail(array $recipients, string $subject, string $body, bool $addCC = false) {

        try {

            foreach($recipients as $recipient) {

                if($addCC) $this->mail->addCC($recipient);
                else $this->mail->addBCC($recipient);
            }
    
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;

            return $this->mail->send();

        } catch (PHPMailerException $e) {

            throw new MailerException($e->getMessage());
        }
    }

}