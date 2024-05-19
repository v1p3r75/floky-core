<?php

namespace Floky\Providers;

use BlakvGhost\PHPValidator\Validator as PHPValidator;
use Floky\Application;
use Floky\Http\Requests\Request;
use Floky\Mail\Adapters\PHPMailerAdapter;
use Floky\Mail\Mailer;
use Floky\Validation\Adapters\BlakvGhostValidatorAdapter;
use Floky\Validation\Validator;
use PHPMailer\PHPMailer\PHPMailer;

abstract class ServiceProvider
{

    protected Application $app;

    public function __construct()
    {
        $this->app = Application::getInstance();

        $this->app->services()->set(Request::class, function() {

            return Request::getInstance();
        });

        $this->app->services()->set(Mailer::class, function() {

            $mailerAdapter = new PHPMailerAdapter(new PHPMailer(true));
            return new Mailer($mailerAdapter);
        });

        $this->app->services()->set(Validator::class, function() {

            return new Validator(new BlakvGhostValidatorAdapter);
        });
    }

    abstract public function register();


}