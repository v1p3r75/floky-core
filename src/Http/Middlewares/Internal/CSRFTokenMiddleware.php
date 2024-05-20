<?php

namespace Floky\Http\Middlewares\Internal;

use Closure;
use Exception;
use Floky\Exceptions\UnAuthorizedException;
use Floky\Auth\Security;
use Floky\Session\Session;
use Floky\Http\Middlewares\MiddlewareInterface;
use Floky\Http\Requests\Request;

class CSRFTokenMiddleware implements MiddlewareInterface
{

    protected array $except = [];

    public function handle(Request $request, Closure $next)
    {
        if (! in_array($request->getUri(), $this->except) && $request->isPost()) {

            if (! Security::checkToken($request->input(Session::TOKEN))) {
    
               throw new UnAuthorizedException('Invalid CSRF token');
           }
        }

        return $next($request);

    }
}