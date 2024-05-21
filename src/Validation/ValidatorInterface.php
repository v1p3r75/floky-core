<?php

namespace Floky\Validation;


interface ValidatorInterface 
{

    public function validate(array $data, array $rules, array $messages = []);

}