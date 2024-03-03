<?php

/*
* TODO: Finish RouteGroup Development ...
*/

namespace Floky\Routing;

use Closure;
use ErrorException;
use Floky\Exceptions\Code;
use Floky\Exceptions\ParseErrorException;


trait RouteGroup
{

    private static bool $isGroup = false;

    private static array $groups = [];

    private static ?string $current_group = null;

    public static function group(callable $callback)
    {
        self::$current_group = uniqid("group_");
        self::$isGroup = true;
        call_user_func($callback);
        self::$isGroup = false;
        return new static;
    }

    public static function prefix(string $name)
    {

        self::isValid('prefix');

        try {

            self::$groups[self::$current_group] = array_map(function ($route) use ($name) {

                // if the saved uri is blanck ("") d'ont add a slash

                $route['uri'] = $route['uri'] == "" ?
                    trim($name, "/") . $route['uri'] :
                    trim($name) . "/" . $route['uri'];

                return $route;
            }, self::$groups[self::$current_group]);
        } catch (ErrorException $e) {

            throw new ParseErrorException("'prefix' can only be used on a group", 2000);
        }

        return new static;
    }

    public static function controller(Closure | array $controller)
    {

        self::isValid('controller');

        try {

            self::$groups[self::$current_group] = array_map(function ($route) use ($controller) {

                $route['callback'] = $controller;

                return $route;
            }, self::$groups[self::$current_group]);
        } catch (ErrorException $e) {

            throw new ParseErrorException("'controller' can only be used on a group", 2000);
        }

        return new static;
    }

    public static function groupMiddlewares(array $middlewares)
    {

        self::isValid('groupMiddlewares');

        try {

            self::$groups[self::$current_group] = array_map(function ($route) use ($middlewares) {

                if (!isset($route['middlewares'])) {
                    $route['middlewares'] = [];
                }

                $route['middlewares'] = array_merge($route['middlewares'], $middlewares);

                return $route;
            }, self::$groups[self::$current_group]);
        } catch (ErrorException $e) {

            throw new ParseErrorException("'groupMiddlewares' can only be used on a group", 2000);
        }

        return new static;
    }


    private static function isValid(string $for = ""): void
    {
        if (self::$isGroup) {

            throw new ParseErrorException("'$for' can only be used on a group", 2000);
        }
    }
    public static function getGroups(): array
    {
        $groups = [];

        foreach (self::$groups as $group) {

            $groups = array_merge($groups, $group);
        }

        return $groups;
    }
}
