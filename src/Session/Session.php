<?php

namespace Floky\Session;

class Session implements \ArrayAccess
{

    const TOKEN = 'csrf_token';

    public static function get($key): mixed
    {

        if (isset($_SESSION[$key])) {

            return $_SESSION[$key];
        }

        return false;
    }

    public static function set($key, $value): bool
    {

        $_SESSION[$key] = $value;

        return true;
    }

    public static function getId(): string | false
    {

        return session_id();
    }

    public static function setId(string $value): string | false
    {

        return session_id($value);
    }

    public static function setName(string $value) {

        return session_name($value);
        
    }

    public static function has(string $key) {

        return isset($_SESSION[$key]);

    }

    public static function delete(string $key) {

        unset($_SESSION[$key]);
    }

    public function offsetExists(mixed $offset): bool
    {
        return self::has($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return self::get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        self::set($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        
        self::delete($offset);
    }

}
