<?php

namespace Floky\Http\Middlewares;

use Floky\Application;
use Floky\Http\Kernel;
use Floky\Http\Requests\Request;

trait Middlewares
{

    private static function runMiddlewares(array $middlewares, Request $request) {

        if (count($middlewares) > 0) {

            $currentMiddleware = new $middlewares[0];

            $currentRequest = $currentMiddleware->handle($request, function ($nextRequest) use ($middlewares) {

                return self::runMiddlewares(array_slice($middlewares, 1), $nextRequest);
            });

            return $currentRequest;
        }

        return $request;

    }

    private static function getMiddleware(string $name, Kernel $kernel) {

        return $kernel->getMiddleware($name);

    }

    private static function getMiddlewareArray(array $middlewares, Kernel $kernel): array {

        $result = [];

        foreach($middlewares as $middleware) {

            if ($found = self::getMiddleware($middleware, $kernel)) {

                $result[] = $found;
            }
        }

        return $result;
    }
}