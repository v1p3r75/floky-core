<?php
use Floky\Http\Controllers\Controller;
use Floky\Http\Requests\Request;
use Floky\Http\Responses\Response;

it('controller contains a valides properties', function() {

    $controller = new Controller();

    expect($controller->request)->toBeInstanceOf(Request::class);
    expect($controller->response)->toBeInstanceOf(Response::class);
});