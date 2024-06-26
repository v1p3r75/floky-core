<?php

namespace Floky;

use Dotenv\Dotenv;
use Error;
use ErrorException;
use Exception;
use Floky\Container\Container;
use Floky\Exceptions\Code;
use Floky\Exceptions\NotFoundException;
use Floky\Config\Config;
use Floky\Auth\Security;
use Floky\Http\Controllers\Controller;
use Floky\Http\Kernel;
use Floky\Http\Middlewares\Middlewares;
use Floky\Http\Requests\Request;
use Floky\Routing\Attributes\RouteAttribute;
use Floky\Routing\Route;
use Highlight\Highlighter;
use ReflectionAttribute;

class Application
{

    use Middlewares;

    const PRODUCTION = 'production';

    const DEVELOPMENT = 'development';

    const DOWN = 'down';

    public Container $container;

    public Request $request;

    private Highlighter $hl;

    public static ?string $root_dir;

    public static string $core_dir;

    public static ?Application $instance = null;

    private function __construct(?string $root_dir = null, bool $isConsole = false)
    {

        self::$root_dir = $root_dir;
        self::$core_dir = __DIR__;
        Config::loadEnv(Dotenv::createImmutable(dirname(self::$root_dir)));

        if (!$isConsole) {

            set_exception_handler([$this, 'handleException']);
            set_error_handler([$this, 'handleError']);

            $this->hl = new Highlighter;
            $this->request = Request::getInstance();
            $this->container = Container::getInstance();
        }
    }

    public static function getInstance(?string $root_dir = null, bool $isConsole = false)
    {

        if (!self::$instance) {

            self::$instance = new self($root_dir, $isConsole);
        }

        return self::$instance;
    }

    /**
     * Save all applications services
     */
    private function saveAppServices()
    {

        return (new \App\Providers\AppServiceProvider)->register();
    }

    public function services(): Container
    {

        return $this->container;
    }

    /**
     * Start a new application
     */
    public function run()
    {

        require(__DIR__ . "/Helpers.php"); // load function helpers

        $this->saveAppServices();

        // Collect GET, POST, PUT, PATCH, DELETE together
        $requestData = $this->collectRequestData();
        $this->request->saveRequestData($requestData);

        // Run all app middlewares before run current route

        $httpKernel = self::getHttpKernel();

        $return = $this->runMiddlewares($httpKernel->getAllMiddlewares(), $this->request);

        if ($return instanceof Request) {

            return $this->dispatch($this->request, $httpKernel);
        }
    }


    private function dispatch(Request $request, Kernel $kernel)
    {

        $this->loadAppRoutes();

        return Route::dispatch($request, $kernel);
    }


    public static function getHttpKernel()
    {
        $appHttpKernel = app_http_path("Kernel.php");

        $appHttpKernel = app_http_path("Kernel.php");

        $httpKernel = require($appHttpKernel);

        return $httpKernel;
    }

    private function loadAppRoutes(): void
    {

        if (Config::get('app.providers.routing.attributes_in_controllers') || true) {

            $this->loadRouteInControllers();
        }

        if (Config::get('app.providers.routing.routing_in_files') || false) {

            $kernel = self::getHttpKernel();

            $path = app_routes_path();

            foreach ($kernel->getRoutesGroup() as $group) {

                $group_file = $path . $group . ".php";

                if (file_exists($group_file)) {

                    require_once $group_file;
                } else
                    throw new NotFoundException("'$group' is registered but its file cannot be found. Make sure to create its file in " . app_routes_path(), Code::FILE_NOT_FOUND);
            }
        }
    }

    private function loadRouteInControllers(): void
    {

        $controllers = $this->getControllers();

        foreach ($controllers as $controller) {

            $reflection = new \ReflectionClass($controller);
            $methods = $reflection->getMethods();

            foreach ($methods as $method) {

                if ($method->isConstructor()) continue;

                $attributes = $method->getAttributes(RouteAttribute::class, ReflectionAttribute::IS_INSTANCEOF);

                if ($attributes) {

                    foreach ($attributes as $attribute) {

                        $routeAttribute = $attribute->newInstance();
                        $resolvedConstructor = $this->services()->get($controller);
                        $callback = $method->getClosure($resolvedConstructor);
                        $routeAttribute->run($callback);
                    }
                }
            }
        }
    }
    private function getControllers(): array
    {

        $path = app_controllers_path();

        $files = Config::getDirectoryFiles($path, true);

        $files = array_map(function ($file) {

            $namespace = $this->getNamespaceFromPath(pathinfo($file, PATHINFO_DIRNAME));

            $class = $namespace . pathinfo($file, PATHINFO_FILENAME);

            if (
                pathinfo($file, PATHINFO_EXTENSION) === 'php' &&
                class_exists($class) &&
                is_subclass_of($class, Controller::class)
            )

                return $class;
        }, $files);

        return array_filter($files, fn ($file) => !is_null($file));
    }

    private function getNamespaceFromPath(string $path): string
    {
        $appSrc = $this->getAppDirectory();

        if (str_starts_with($path, $appSrc)) {

            $path = str_replace($appSrc, "", $path);
            $path = trim(str_replace("/", "\\", $path), "\\");

            return ucfirst($path) . "\\";
        }

        return "";
    }

    public static function getAppDirectory()
    {

        return self::$root_dir;
    }

    private function collectRequestData(): array
    {

        $specialMethods = ['PUT', 'PATCH', 'DELETE'];

        $data = []; // for specials methods

        if (in_array($this->request->getMethod(), $specialMethods)) {

            $requestContent = file_get_contents('php://input');

            $data = json_decode($requestContent, true);

            if (is_null($data)) { // if is not a valid json. Ex: content = "var=2&m=4"

                parse_str($requestContent, $data);
            }
        }

        return ['get' => $_GET, 'post' => $_POST, 'other' => $data];
    }

    public function handleError(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        if (!(error_reporting() & $errno)) {
            // This error code is not included in error_reporting, so let it fall
            // through to the standard PHP error handler
            return false;
        }

        throw new ErrorException(
            Security::secure($errstr),
            $errno,
            E_ERROR,
            $errfile,
            $errline,
            null
        );
    }

    public function handleException(Exception | Error $err)
    {

        $exceptsInProduction = [Code::FORBIDDEN, Code::PAGE_NOT_FOUND, Code::UNAUTHORIZED, Code::APP_DOWN];

        $currentEnv = Config::get('app.environment') ?? Application::PRODUCTION;

        $template = match ($err->getCode()) {

            Code::PAGE_NOT_FOUND => 'templates.404',
            Code::FORBIDDEN, => 'templates.403',
            Code::UNAUTHORIZED => 'templates.401',
            Code::APP_DOWN => 'templates.maintenance',

            default => 'templates.errors',
        };

        if ($currentEnv == Application::PRODUCTION) {

            if (!in_array($err->getCode(), $exceptsInProduction)) {

                if ($this->request->header()->acceptJson()) { // for api mode

                    return response()->json(['error' => 'An error has occurred in the application. Please contact the administrator']);
                }

                return view_resource('templates.production');
            }

            return view_resource($template);
        }

        $data = [
            'name' => $err::class,
            'file' => $err->getFile(),
            'line' => $err->getLine(),
            'message' => $err->getMessage(),
            'code' => $err->getCode(),
            'previews' => $err->getTrace(),
        ];

        if ($this->request->header()->acceptJson()) { // for api mode

            return response()->json($data);
        }

        //TODO: return xml response

        $data['previews'] = $this->getCodePreview($err->getTrace());

        return view_resource($template, $data);
    }

    private function getCodePreview(array $traceback)
    {

        $traces = [];

        foreach ($traceback as $trace) {

            if ($code = $this->getPreview($trace)) {

                $content = $this->hl->highlight('php', $code);
                $content->filename = $trace['file'];

                $traces[] = $content;
            }
        }

        return $traces;
    }

    private function getPreview($trace)
    {

        if (!isset($trace["file"])) return false;
        $lines = file($trace['file']);
        $start = max(0, $trace['line'] - 5);
        $end = min(count($lines), $trace['line'] + 5);
        $codePreview = array_slice($lines, $start, $end - $start);

        return implode("", $codePreview);
    }
}
