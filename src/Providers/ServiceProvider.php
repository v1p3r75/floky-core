<?php

namespace Floky\Providers;

use Floky\Application;
use Floky\Http\Requests\Request;

abstract class ServiceProvider
{

    protected Application $app;

    public function __construct()
    {
        $this->app = Application::getInstance();

        $this->app->services()->set(Request::class, function() {

            return Request::getInstance();
        });
    }

    abstract public function register();


}