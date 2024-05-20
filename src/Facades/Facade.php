<?php

namespace Floky\Facades;

use Floky\Application;
use Floky\Validation\Validator;

class Facade
{

    protected static $class;

    // protected static function getTargetClass() {}

    public static function __callStatic($method, $args) {

        $services = Application::getInstance()->services();

        return  call_user_func_array([$services->get(Validator::class), $method], $args);

    } 
}