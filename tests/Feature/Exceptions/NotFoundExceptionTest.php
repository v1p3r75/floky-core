<?php

use Floky\Exceptions\Code;
use Floky\Exceptions\NotFoundException;

it('throws NotFound Exception', function () {

    throw new NotFoundException('Not Found', Code::FILE_NOT_FOUND);
})->throws(Exception::class, 'Not Found', Code::FILE_NOT_FOUND);