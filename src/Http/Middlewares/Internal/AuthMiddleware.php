<?php

namespace Floky\Http\Middlewares\Internal;

use Closure;
use Floky\Facades\Auth;
use Floky\Http\Middlewares\MiddlewareInterface;
use Floky\Http\Requests\Request;
use Floky\Exceptions\ForbiddenException;

class AuthMiddleware implements MiddlewareInterface
{

    protected array $except = [];

    public function handle(Request $request, Closure $next)
    {

        if (! in_array($request->getUri(), $this->except)) {
            
            if (!Auth::user()) {

                throw new ForbiddenException("You are not authorized to access this page");
            }
        }
        
        return $next($request);

    }
}