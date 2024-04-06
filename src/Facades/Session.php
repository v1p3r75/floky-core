<?php

namespace Floky\Facades;

class Session extends Facades
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

}
