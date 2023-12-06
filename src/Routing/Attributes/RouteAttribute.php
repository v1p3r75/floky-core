<?php

namespace Floky\Routing\Attributes;

abstract class RouteAttribute
{
    public function __construct
    (
        protected string $uri,
        protected ?string $name = null,
        protected array $middlewares = []
    ){
        }

    abstract public function run($callback);
}