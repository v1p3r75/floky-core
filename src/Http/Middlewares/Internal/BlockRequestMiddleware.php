<?php

namespace Floky\Http\Middlewares\Internal;

use Floky\Exceptions\ApplicationDownException;
use Floky\Facades\Config;
use Floky\Http\Middlewares\MiddlewareInterface;
use Floky\Http\Requests\Request;

class BlockRequestMiddleware implements MiddlewareInterface
{

    protected array $except = [];

    public function handle(Request $request): Request
    {
        if (! in_array($request->getUri(), $this->except)) {

            if(Config::get('app.maintenance')) {

                throw new ApplicationDownException('The application is in maintenance mode.');
            }
        }

        return $request;

    }
}