<?php

namespace Floky\Facades;


class Security extends Facades
{
    public static function check(string $password, string $hached_password): bool
    {

        return password_verify($password, $hached_password);

    }

    public static function hash(string $password, array $options = []) : string
    {

        $algo = $options['algo'] ?? PASSWORD_DEFAULT;

        return password_hash($password, $algo);
    }

    public static function secure(array | string $data)
    {
        if (is_array($data)) {

            return array_map(fn($value) => self::secure($value), $data);
    
        }

        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    
    }

    public static function generateCSRFToken(): string {

        $token = bin2hex(random_bytes(32));

        Session::set(Session::TOKEN, $token);

        return $token;
    }

    public static function checkToken($token): bool {

        
        return isset($token) && Session::get(Session::TOKEN) === $token;
    }
    
}