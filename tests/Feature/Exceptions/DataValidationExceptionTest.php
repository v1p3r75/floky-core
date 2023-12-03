<?php

use Floky\Exceptions\Code;
use Floky\Exceptions\DataValidationException;

it('throws Data Vlidation Exception', function () {

    throw new DataValidationException('validation errors', Code::DATA_VALIDATION);

})->throws(Exception::class, 'validation errors', Code::DATA_VALIDATION);