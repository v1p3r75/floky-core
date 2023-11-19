<?php

namespace Floky\Routing\Attributes;

use ReflectionException;
use ReflectionMethod;

class RouteAttribute
{

    /**
     * @throws ReflectionException
     */
    public function getCallback(): callable
    {
        $reflection = new ReflectionMethod($this::class);

        return $reflection->getClosure();
    }

}