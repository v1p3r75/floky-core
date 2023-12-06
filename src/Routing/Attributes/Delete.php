<?php

namespace Floky\Routing\Attributes;

use Attribute;
use Floky\Routing\Route;


#[Attribute(Attribute::TARGET_METHOD)]
class Delete extends RouteAttribute
{

    public function run($callback)
    {

        return $this->save(Route::delete($this->uri, $callback));
    }
}