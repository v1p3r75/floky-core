<?php

namespace Floky\Validation\Adapters;

use BlakvGhost\PHPValidator\Validator as PHPValidator;
use Floky\Exceptions\DataValidationException;
use Floky\Validation\ValidatorInterface;

class BlakvGhostValidatorAdapter implements ValidatorInterface

{

    public function __construct() {}

    public function validate(array $data, array $rules, array $messages = []) {

        try {

            return new PHPValidator($data, $rules, $messages);

        } catch(\BlakvGhost\PHPValidator\ValidatorException $e) {

            throw new DataValidationException($e->getMessage());
        } 
    }
}