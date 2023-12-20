<?php

namespace Floky\Routing\Attributes;

use Attribute;
use Floky\Routing\Route;


#[Attribute(Attribute::TARGET_METHOD)]
class Put extends RouteAttribute
{

    public function run(\Closure $callback)
    {

        return $this->save(Route::put($this->uri, $callback));
    }
}