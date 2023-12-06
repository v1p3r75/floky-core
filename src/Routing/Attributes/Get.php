<?php

namespace Floky\Routing\Attributes;

use Attribute;
use Floky\Routing\Route;


#[Attribute(Attribute::TARGET_METHOD)]
class Get extends RouteAttribute
{

    public function run($callback)
    {

        $route = Route::get($this->uri, $callback)
            ->middlewares($this->middlewares);
            
        if($this->name) $route->name($this->name);
    }
}