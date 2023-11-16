<?php

namespace Floky\Facades;

use BlakvGhost\PHPValidator\Validator as PHPValidator;

class Validator
{

    public static function validate($data, $rules) {

        return new PHPValidator($data, $rules);
    }
}