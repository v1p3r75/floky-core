<?php

namespace Floky\Facades;

use Floky\Application;
use Floky\Validation\Validator;

abstract class Facade
{

    // protected static function getTargetClass() {}

    public static function __callStatic($method, $args) {

        $services = Application::getInstance()->services();
        $method = $services->getMethod(self::getTargetClass(), $method, $args);

        return $services->runMethod($method);
    } 
}