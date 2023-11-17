<?php
use Floky\Http\Requests\Request;

it('should return a valid Request class', function() {

    expect($this->request)->toBeInstanceOf(Request::class);
});