<?php

namespace Floky\Routing\Attributes;

use Attribute;
use Floky\Routing\Route;


#[Attribute(Attribute::TARGET_METHOD)]
class MatchWith extends RouteAttribute
{

    public function __construct(protected array $methods, string $uri, $name = null, array $middlewares = [])
    {
        parent::__construct($uri, $name, $middlewares);
    }

    public function run($callback)
    {

        return $this->save(Route::match($this->methods, $this->uri, $callback));
    }
}