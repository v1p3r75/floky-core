<?php

namespace Floky\Facades;

use Floky\Application;

class Facade
{


    public static function __callStatic($method, $args) {

        $services = Application::getInstance()->services();

        return  call_user_func_array([$services->get(static::getTargetClass()), $method], $args);

    } 
}