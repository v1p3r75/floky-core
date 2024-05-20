<?php

use Floky\Container\Container;

it('should return valid Container class', function () {
    
    expect($this->app->services())->toBeInstanceOf(Container::class);
});
