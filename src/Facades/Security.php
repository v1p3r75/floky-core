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

            foreach ($data as $key => $value) {
                
                $data[$key] = secure($value);
            }
    
        } else {
    
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }
    
        return $data;
    }

    public static function generateCSRFTtoken(): string {

        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;

        return $token;
    }

    public static function checkToken($token): bool {

        
        return isset($token) && $_SESSION['csrf_token'] === $token;
    }
    
}