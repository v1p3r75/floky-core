<?php

namespace Floky\Routing\Attributes;

use Attribute;
use Floky\Exceptions\ParseErrorException;
use Floky\Routing\Route;

#[Attribute(Attribute::TARGET_METHOD)]
class Get extends RouteAttribute
{

    public function __construct(string $uri, string $name, ?array $middlewares = []) {

        Route::get($uri, $this->getCallback())->name($name)->middlewares($middlewares);
    }
}