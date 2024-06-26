<?php

namespace Floky\Routing;

use Closure;
use Floky\Application;
use Floky\Exceptions\Code;
use Floky\Exceptions\NotFoundException;
use Floky\Exceptions\ParseErrorException;
use Floky\Http\Kernel;
use Floky\Http\Middlewares\Middlewares;
use Floky\Http\Requests\Request;

class Route
{

    use Middlewares;

    private static array $routes = [];

    private static string $defaultMethod = 'index';

    private static array $verbs = ['GET', 'HEAD', 'OPTIONS', 'POST', 'PUT', 'PATCH', 'DELETE'];

    private static array $resourceStub = [
        '/' => ['method' => ['GET'], 'function' => 'index'],
        '/show/{id}' => ['method' => ['GET'], 'function' => 'show'],
        '/create' => ['method' => ["POST"], 'function' => 'create'],
        '/edit/{id}' => ['method' => ["GET"], 'function' => 'edit'],
        '/update' => ['method' => ["POST", "PATCH", "PUT"], 'function' => 'update'],
        '/delete' => ['method' => ["POST", "DELETE"], 'function' => 'delete'],
    ];

    private static ?string $current_route = null;


    private static function methodIsCorrect(string | array $method = ''): bool
    {
        if (is_array($method)) {

            foreach ($method as $value) {

                if (!in_array(strtoupper($value), self::$verbs)) {
                    return false;
                }
            }
            return true;
        }

        return in_array(strtoupper($method), self::$verbs);
    }

    public static function get(string $uri, array | Closure | null $callback = null)
    {

        return self::add($uri, ['GET', 'HEAD'], $callback);
    }
    public static function post(string $uri, array | Closure | null $callback = null)
    {

        return self::add($uri, ['POST'], $callback);
    }
    public static function put(string $uri, array | Closure | null $callback = null)
    {

        return self::add($uri, ['PUT'], $callback);
    }
    public static function patch(string $uri, array | Closure | null $callback = null)
    {

        return self::add($uri, ['PATCH'], $callback);
    }
    public static function delete(string $uri, array | Closure | null $callback = null)
    {

        return self::add($uri, ['DELETE'], $callback);
    }

    public static function options(string $uri, array | Closure | null $callback = null)
    {

        return self::add($uri, ['OPTIONS'], $callback);
    }

    public static function match(array $methods, string $uri, array | Closure | null $callback = null)
    {

        return self::add($uri, $methods, $callback);
    }

    public static function any(string $uri, array | Closure | null $callback = null)
    {

        return self::add($uri, self::$verbs, $callback);
    }

    public static function resource(string $name, string $controller, array $middlewares = [], array $except = [])
    {
        // TODO: Excepting URIs

        $name = trim($name, '/');

        foreach (self::$resourceStub as $uri => $data) {

            self::add($name . $uri, $data['method'], [$controller, $data['function']]);
            self::middlewares($middlewares);
        }

    }


    private static function add(string $uri, array $method, Closure | callable | array | null $callback)
    {

        self::$current_route = uniqid("route_");

        if (!self::methodIsCorrect($method)) {

            throw new ParseErrorException("Route does not support " . implode(",", $method) . " method", Code::UNKNOW_METHOD);
        }

        $uri = self::format_uri($uri);

        $payload = ['uri' => $uri, 'methods' => $method, 'callback' => $callback];

        self::$routes[self::$current_route] = $payload;

        return new static;
    }

    public static function dispatch(Request $request, Kernel $kernel)
    {

        $method = $request->getMethod();

        $current_uri = self::format_uri($request->getUri());

        // if (!self::methodIsCorrect($method)) {

        //     throw new ParseErrorException("Router does not support '$method'  method");
        // }

        foreach (self::getAll() as $route) {

            $current_route = $route['uri'];

            $routeRegex = "@^" . preg_replace_callback("/{(\w+)(:[^}]+)?}/", fn ($m) => isset($m[2]) ? "({$m[2]})" : "(\w+)", $current_route) . "(\\?.*)?$@";

            if (preg_match_all($routeRegex, $current_uri, $matches)) {

                $route_methods = $route['methods'];

                $route_callback = $route['callback'];

                if (!in_array($method, $route_methods)) { // Bad route method

                    throw new ParseErrorException("The '" . $route['uri'] . "' route does not support the '$method' method but: " . implode(",", $route_methods), Code::BAD_METHOD);
                }

                $params = [];

                for ($i = 1; $i < count($matches); $i++) {
                    $params[] = $matches[$i][0]; // List of parameters that will parse to function

                }

                if (isset($route['middlewares'])) {

                    $route_middlewares = self::getMiddlewareArray($route['middlewares'], $kernel);

                    self::runMiddlewares($route_middlewares, $request);
                }

                return self::runCallback($route_callback, $params);
            }
        }

        throw new NotFoundException('Page Not found', Code::PAGE_NOT_FOUND);
    }

    public static function runCallback(array | Closure | callable | null $callback, array $params = [])
    {

        $app = Application::getInstance();

        if (is_array($callback)) {

            $controller = $app->services()->get($callback[0]);

            $method = $callback[1] ?? self::$defaultMethod;

            $resolved_method = $app->services()->getMethod($controller, $method, $params); // Get class & dependencies

            return $app->services()->runMethod($resolved_method);
        } else if (is_callable($callback)) {

            $resolved_callback = $app->services()->resolveFunction($callback, $params);

            return call_user_func_array($resolved_callback[0], $resolved_callback[1]);
        }

        throw new ParseErrorException('Not callback found for this route.', 2000);
    }

    public static function middlewares(array $middlewares = [])
    {

        self::$routes[self::$current_route]['middlewares'] = $middlewares;

        return new static;
    }

    public static function name(string $name)
    {
        foreach (self::getAll() as $route) {

            if (isset($route["name"]) && $route["name"] == $name) {

                $found = $route['uri'] == "" ? '/' : $route['uri'];
                throw new ParseErrorException("'$name' is already used by '$found'", Code::ROUTE_ALREADY_EXIST);
            }
        }

        self::$routes[self::$current_route]['name'] = $name;

        return new static;
    }

    private static function format_uri(string $uri)
    {

        return trim($uri, "/");
    }

    public static function getAll(): array
    {

        return self::$routes;
    }

    public static function getRouteByName(string $name)
    {

        foreach (self::$routes as $route) {

            if (isset($route['name']) && $route['name'] == $name) {

                return $route;
            }
        }

        return null;
    }
}
