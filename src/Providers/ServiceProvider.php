<?php

namespace Floky\Providers;

use eftec\bladeone\BladeOne;
use Floky\Application;
use Floky\Http\Requests\Request;
use Floky\Mail\Adapters\PHPMailerAdapter;
use Floky\Mail\Mailer;
use Floky\Mail\MailerInterface;
use Floky\Validation\Adapters\BlakvGhostValidatorAdapter;
use Floky\Validation\ValidatorInterface;
use Floky\View\Adapters\BladeOneAdapter;
use Floky\View\View;
use Floky\View\ViewInterface;
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

        $this->app->services()->set(MailerInterface::class, function() {

            return new PHPMailerAdapter(new PHPMailer(true));
        });

        $this->app->services()->set(ValidatorInterface::class, function() {

            return new BlakvGhostValidatorAdapter;
        });
        
        $this->app->services()->set(ViewInterface::class, function() {
            
            return new BladeOneAdapter(new BladeOne);
        });
    }

    abstract public function register();


}