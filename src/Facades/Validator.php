<?php

namespace Floky\Facades;

use Floky\Validation\Validator as ValidationValidator;

class Validator extends Facade
{

    public static function getTargetClass(): string
    {
     
        return ValidationValidator::class;
    }
}