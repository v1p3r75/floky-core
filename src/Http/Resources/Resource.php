<?php

namespace Floky\Http\Resources;

use Floky\Http\Requests\Request;

abstract class Resource 
{

    public function __construct(protected mixed $resource) {

    }

    abstract public function get(): array;

    public function __get($name)
    {        
        return $this->resource[$name] ?? null;
    }

}