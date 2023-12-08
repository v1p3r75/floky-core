<?php

namespace Floky\Routing\Attributes;

use Attribute;
use Floky\Routing\Route;


#[Attribute(Attribute::TARGET_METHOD)]
class Patch extends RouteAttribute
{

    public function run(\Closure $callback)
    {

        return $this->save(Route::patch($this->uri, $callback));
    }
}