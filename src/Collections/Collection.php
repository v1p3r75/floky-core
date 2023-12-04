<?php

namespace Floky\Collections;

class Collection 
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
}