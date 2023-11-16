<?php

namespace Floky\Facades;

use BlakvGhost\PHPValidator\Validator as PHPValidator;

class Validator
{

    public static function validate(array $data, array $rules) {

        return new PHPValidator($data, $rules);
    }
}