<?php

namespace Floky\Facades;

/**
 * @method mixed render(string $view, array $data = [])
 */
class View extends Facade
{

    protected static function getTargetClass(): string
    {
        return \Floky\View\View::class;
    }
}