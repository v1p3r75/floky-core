<?php

namespace Floky\Http\Middlewares;

use Closure;
use Floky\Http\Requests\Request;

interface MiddlewareInterface
{

    public function handle(Request $request, Closure $next);
    
}