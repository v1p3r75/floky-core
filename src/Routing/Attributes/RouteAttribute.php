<?php

namespace Floky\Routing\Attributes;

use Closure;
use Floky\Routing\Route;

abstract class RouteAttribute
{
    public function __construct
    (
        protected string $uri,
        protected ?string $name = null,
        protected array $middlewares = []
    ){
        }

    abstract public function run(Closure $callback);

    protected function save(Route $instance) {

        $route = $instance->middlewares($this->middlewares);
            
        if($this->name) $route->name($this->name);
    }
}