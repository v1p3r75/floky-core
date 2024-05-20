<?php

namespace Floky\Facades;

class View extends Facade
{

    protected static function getTargetClass(): string
    {
        return \Floky\View\View::class;
    }
}