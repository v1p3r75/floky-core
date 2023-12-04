<?php

namespace Floky\Http\Middlewares\Internal;

use Floky\Exceptions\ApplicationDownException;
use Floky\Http\Middlewares\MiddlewareInterface;
use Floky\Http\Requests\Request;

class BlockRequestMiddleware implements MiddlewareInterface
{

    protected array $except = [];

    public function handle(Request $request): Request
    {
        if (! in_array($request->getUri(), $this->except)) {

            throw new ApplicationDownException('The app is in maintenance');
        }

        return $request;

    }
}