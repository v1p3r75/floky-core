<?php

use Floky\Application;

it('application instance is created successfully', function() {


    expect($this->app)->toBeInstanceOf(Application::class);

});

it('application services method should return a valid Container class', function () {

    expect($this->app->services())
        ->toBeInstanceOf(\Floky\Container\Container::class);
});