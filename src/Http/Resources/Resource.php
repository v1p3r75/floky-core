<?php

namespace Floky\Http\Resources;

use Floky\Http\Requests\Request;

abstract class Resource 
{

    public function __construct(protected mixed $resource) {

    }

    abstract protected function toArray(Request $request): array;

    public function __get($name)
    {        
        return $this->resource[$name] ?? null;
    }

}