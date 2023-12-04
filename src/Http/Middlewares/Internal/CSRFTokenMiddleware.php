<?php

namespace Floky\Http\Middlewares\Internal;

use Exception;
use Floky\Exceptions\UnAuthorizedException;
use Floky\Facades\Security;
use Floky\Facades\Session;
use Floky\Http\Middlewares\MiddlewareInterface;
use Floky\Http\Requests\Request;

class CSRFTokenMiddleware implements MiddlewareInterface
{

    protected array $except = [];

    public function handle(Request $request): Request
    {
        if (! in_array($request->getUri(), $this->except) && $request->isPost()) {

            if (! Security::checkToken($request->input(Session::TOKEN))) {
    
               throw new UnAuthorizedException('Invalid CSRF token');
           }
        }

        return $request;

    }
}