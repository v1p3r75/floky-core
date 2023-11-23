<?php

namespace Floky\Facades;

class Session extends Facades
{

    public static function get($key): string | false
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
    
}
