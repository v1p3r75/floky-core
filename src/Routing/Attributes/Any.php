<?php

namespace Floky\Routing\Attributes;

use Attribute;
use Floky\Routing\Route;


#[Attribute(Attribute::TARGET_METHOD)]
class Any extends RouteAttribute
{

    public function run($callback)
    {

        return $this->save(Route::any($this->uri, $callback));
    }
}