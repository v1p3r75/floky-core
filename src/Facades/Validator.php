<?php

namespace Floky\Facades;

/**
 * @method static mixed validate(array $data, array $rules, array $messages = [])
 */
class Validator extends Facade
{


    protected static function getTargetClass(): string
    {
     
        return \Floky\Validation\Validator::class;
    }
}