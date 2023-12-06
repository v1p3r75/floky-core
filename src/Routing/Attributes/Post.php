<?php

namespace Floky\Routing\Attributes;

use Attribute;
use Floky\Routing\Route;


#[Attribute(Attribute::TARGET_METHOD)]
class Post extends RouteAttribute
{

    public function run($callback)
    {

        return $this->save(Route::post($this->uri, $callback));
    }
}