<?php

namespace Floky\Http\Middlewares;

use Floky\Http\Requests\Request;

interface MiddlewareInterface
{

    public function handle(Request $request): Request;
    
}