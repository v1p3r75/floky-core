<?php

namespace Floky\Facades;

use BlakvGhost\PHPValidator\Validator as PHPValidator;

class Validator extends Facades
{

    public static function validate(array $data, array $rules, array $messages = []) {

        return new PHPValidator($data, $rules, $messages);
    }
}