<?php

namespace Floky\Validation;


class Validator
{

    public function __construct(private ValidatorInterface $validator) {}


    public function validate(array $data, array $rules, array $messages = []) {

        return $this->validator->validate($data, $rules, $messages);
    }
}