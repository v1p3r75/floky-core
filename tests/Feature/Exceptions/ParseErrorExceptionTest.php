<?php

use Floky\Exceptions\ParseErrorException;

it('throws ParseError Exception', function () {

    throw new ParseErrorException('Parse Error');
})->throws(Exception::class, 'Parse Error');