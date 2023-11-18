<?php

use eftec\bladeone\BladeOne;
use Floky\Application;
use Floky\Container\Container;

it('should return a valid app instance', function() {


    expect($this->app)->toBeInstanceOf(Application::class);

});

it('services method should return a valid Container class', function () {

    expect($this->app->services())
        ->toBeInstanceOf(Container::class);
});

it('return bladeOne instance successfully', function () {

    expect($this->app->getBlade())->toBeInstanceOf(BladeOne::class);
});

it('return the route dir ', function() {

    expect($this->app->getAppDirectory())
        ->toBe("$this->app::$root_dir");
});
    