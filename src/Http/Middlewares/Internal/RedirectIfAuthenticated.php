<?php

namespace Floky\Http\Middlewares\Internal;

use Closure;
use Floky\Facades\Auth;
use Floky\Http\Middlewares\MiddlewareInterface;
use Floky\Http\Requests\Request;

class RedirectIfAuthenticated implements MiddlewareInterface
{

    protected string $redirect_to;

    public function handle(Request $request, Closure $next)
    {

        if (Auth::user()) {

            header("Location: " . $this->redirect_to);
        }
        
        return $next($request);
    }
}
