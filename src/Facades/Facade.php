<?php

namespace Floky\Facades;

use Floky\Application;

abstract class Facade
{

    abstract public static function getTargetClass(): string;

    public static function __callStatic($method, $args) {

        $class = Application::getInstance()->services()->get(self::getTargetClass());

        return call_user_func_array([$class, $method], $args);
    } 
}