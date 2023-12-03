<?php

namespace Floky\Facades;

use BlakvGhost\PHPValidator\Validator as PHPValidator;
use Floky\Exceptions\DataValidationException;

class Validator extends Facades
{

    public static function validate(array $data, array $rules, array $messages = []) {

        try {

            return new PHPValidator($data, $rules, $messages);

        } catch(\BlakvGhost\PHPValidator\ValidatorException $e) {

            throw new DataValidationException($e->getMessage());
        } 
    }
}