<?php

namespace Floky\Events;

use Closure;
use Floky\Exceptions\NotFoundException;

class EventManager
{

    private array $listeners = [];


    public function on(string $id, Closure $callback, int $priority = 0) {


        $this->listeners[$id][] = new Listener($callback, $priority);

        $this->sortListeners($id);

    }

    public function emit(string $id, ...$args) {

        if (! $this->has($id)) {

            throw new NotFoundException("[$id] event not found", 4046);
        }

        foreach ($this->listeners[$id] as $listener) {

            $listener->handle($args);
        }

    }

    private function sortListeners(string $id): void
    {

        uasort($this->listeners[$id], fn(Listener $a, Listener $b) => $a->priority < $b->priority);
    }

    public function has(string $id) {

        return isset($this->listeners[$id]);
    }
}