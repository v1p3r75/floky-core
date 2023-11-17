<?php

use Floky\Exceptions\NotFoundException;

it('throws NotFound Exception', function () {

    throw new NotFoundException('Not Found');
})->throws(Exception::class, 'Not Found');