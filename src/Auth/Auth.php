<?php

namespace Floky\Auth;
use Floky\Collections\Collection;
use Floky\Config\Config;
use Floky\Session\Session;

class Auth
{

    const USER_KEY = '_user';

    public static function login(
        string $id,
        string $password,
        array $options = ['id' => 'email', 'password' => 'password']
    ): bool {

        $model = Config::get('auth.model');

        if (!class_exists($model)) {

            throw new \Exception('Auth model not found : ' . $model);
        }

        $model = new $model;

        if ($result = $model->where([$options['id'] => $id])->first()) {

            if (Security::check($password, $result[$options['password']])) {

                unset($result[$options['password']]);
                Session::set(self::USER_KEY, new Collection($result));

                return true;
            }
        }

        return false;
    }

    public static function user() {

        return Session::get(self::USER_KEY) ?? null;
    }

    public static function logout(bool $redirect = true, string $redirect_to = '') {

        Session::set(self::USER_KEY, null);

        if ($redirect) {

            $home = $redirect_to == '' ? \App\Providers\AppServiceProvider::HOME : $redirect_to;

            header("Location: $home");
        }

        return true;
    }
}
