<?php

use Floky\Exceptions\Code;
use Floky\Exceptions\ParseErrorException;

it('throws ParseError Exception', function () {

    throw new ParseErrorException('Parse Error', Code::BAD_METHOD);

})->throws(Exception::class, 'Parse Error', Code::BAD_METHOD);