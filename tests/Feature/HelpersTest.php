<?php

use Floky\Http\Responses\Response;

beforeAll(function() {

    require dirname(dirname(__DIR__)) . '/src/Helpers.php';

});

it('response() should return valid Response class', function () {

    expect(response())->toBeInstanceOf(Response::class);
});