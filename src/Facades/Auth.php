<?php

namespace Floky\Facades;

use Floky\Auth\Auth as AuthAuth;

class Auth extends Facade
{

    protected static function getTargetClass(): string
    {
        return AuthAuth::class;
    }
}
