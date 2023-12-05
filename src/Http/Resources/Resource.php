<?php

namespace Floky\Http\Resources;

use Floky\Http\Requests\Request;
use Floky\Http\Responses\Response;

abstract class Resource
{

    protected string $wrapIn = 'data';

    public function __construct(protected mixed $resource)
    {
    }

    abstract public function toArray(Request $request): array;

    public function toJSON(): Response
    {
        
        return Response::json(
            [
                $this->wrapIn => $this->toArray(Request::getInstance())
            ]
        );
    }

    public function __get($name)
    {
        return $this->resource[$name] ?? null;
    }
}
