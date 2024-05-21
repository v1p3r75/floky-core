<?php

namespace Floky\Events;

use Closure;


class Listener
{

    public function __construct(private Closure $callback, public $priority)
    {
        
    }

    public function handle(array $args) {

        return call_user_func_array($this->callback, $args);
    }
}