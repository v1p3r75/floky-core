<?php

namespace Floky\Collections;

use ArrayAccess;
use Countable;

class Collection implements Countable, ArrayAccess
{

    public function __construct(private array $items){

    }

    public function count(): int
    {

        return count($this->items);
    }

    public function get(string $key): mixed
    {

        return $this->items[$key] ?? null;
    }

    public function all(?callable $callback = null): array {

        return $callback ? $callback($this->items) : $this->items;
    }

    public function __get($name) {

        return $this->get($name);
    }

    public function random()
    {

        $list = $this->all();
        shuffle($list);
        return count($list) > 0 ? $list[0] : [];
    }
    
    public function offsetExists(mixed $offset): bool
    {
        return true;
    }

    public function offsetGet(mixed $offset): mixed
    {
        return 'value';
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        
    }

    public function offsetUnset(mixed $offset): void
    {

    }

}