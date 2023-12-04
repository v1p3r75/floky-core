<?php

namespace Floky\Collections;

use ArrayAccess;
use Countable;

class Collection implements Countable, ArrayAccess
{
    public function __construct(private array $items)
    {
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function get(string $key): mixed
    {
        return $this->items[$key] ?? null;
    }

    public function all(?callable $callback = null): array
    {
        return $callback ? array_map($callback, $this->items) : $this->items;
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function random()
    {
        $list = $this->all();
        shuffle($list);
        return reset($list);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->items[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    public function first()
    {
        return reset($this->items);
    }

    public function last()
    {

        return end($this->items);
    }

    public function filter(callable $callback): Collection
    {
        return new self(array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH));
    }

    public function map(callable $callback): Collection
    {
        return new self(array_map($callback, $this->items));
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    public function values(): array
    {
        return array_values($this->items);
    }

    public function keys(): array
    {
        return array_keys($this->items);
    }
    
    public function isEmpty(): bool
    {
        return empty($this->items);
    }
}
