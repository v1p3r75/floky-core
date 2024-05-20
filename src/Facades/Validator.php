<?php

namespace Floky\Facades;

use Floky\Validation\Validator as ValidationValidator;

/**
 * @method static mixed validate(array $data, array $rules, array $messages = [])
 */
class Validator extends Facade
{

    protected static $class = ValidationValidator::class;

    public static function getTargetClass(): string
    {
     
        return ValidationValidator::class;
    }
}