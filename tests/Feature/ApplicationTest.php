<?php

use Floky\Application;
use Floky\Container\Container;

it('should return a valid app instance', function() {


    expect($this->app)->toBeInstanceOf(Application::class);

});

it('services method should return a valid Container class', function () {

    expect($this->app->services())
        ->toBeInstanceOf(Container::class);
});