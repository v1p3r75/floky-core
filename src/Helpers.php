<?php

use Floky\Application;
use Floky\Exceptions\NotFoundException;
use Floky\Facades\Security;
use Floky\Http\Responses\Response;
use Floky\Routing\Route;
use \Floky\Facades\Validator;


if (!function_exists('secure')) {
    /**
     * Secure data to prevent cross-site scripting (XSS) attacks, supporting strings and arrays.
     *
     * @param array|string $data Data to be secured, can be a string or an array.
     * @return array|string Secured data.
     */
    function secure(array | string $data)
    {

        return Security::secure($data);
    }
}


if (!function_exists('view')) {

    /**
     * Render a view template using Blade with optional data to pass to the view.
     *
     * @param string $name The name of the view template.
     * @param array $data Optional data to pass to the view.
     * @return void
     */

    function view(string $name, $data = [])
    {

        $blade = Application::getBlade();

        echo $blade->run($name, $data);
    }
}

if (!function_exists('view_resource')) {

    /**
     * Render a resource view template using Blade with optional data to pass to the view.
     *
     * @param string $name The name of the resource view template.
     * @param array $data Optional data to pass to the view.
     * @return void
     */
    function view_resource(string $name, $data = [])
    {

        $blade = Application::getBlade(true);
        echo $blade->run($name, $data);
    }
}



if (!function_exists('response')) {

    /**
     * Create a new HTTP response object.
     *
     * @return Response A new HTTP response object.
     */
    function response()
    {
        return new Response();
    }
}


if (!function_exists('route')) {

    /**
     * Retrieve the URI associated with a named route.
     *
     * @param string $name The name of the route.
     * @return string|null The URI of the named route, or `null` if the route does not exist.
     */
    function route(string $name): string | NotFoundException
    {
        $route = Route::getRouteByName($name);

        if (!$route) {

            throw new NotFoundException("The route '$name' doesn't exist.");
        }

        return $route["uri"];
    }
}


if (!function_exists('env')) {

    /**
     * Get the value of an environment variable or return a default value.
     *
     * @param string $key The name of the environment variable.
     * @param string|null $default (Optional) The default value to return if the environment variable is not set.
     * @return string|null The value of the environment variable or the default value if the variable is not set.
     */
    function env(string $key, string $default = null)
    {

        return isset($_ENV[$key]) ? $_ENV[$key] : $default;
    }
}


if (!function_exists('config')) {

    /**
     * Load a configuration file by name and return its contents.
     *
     * @param string $file The name of the configuration file (without the .php extension).
     * @return array The configuration data from the file or an empty array if the file doesn't exist.
     */
    function config(string $file)
    {

        $file = $file . ".php";
        $config_files = get_directory_files(app_config_path());

        if (array_key_exists($file, $config_files)) {

            return require $config_files[$file];
        }

        throw new NotFoundException("'$file' file does not exist in config directory.");
    }
}


if (!function_exists('get_directory_files')) {

    /**
     * Get an array of files in a directory.
     *
     * @param string $dir The path to the directory to scan for files.
     * @return array An associative array where keys are file names and values are their full paths.
     */
    function get_directory_files(string $dir): array
    {

        $files = [];
        $content = scandir($dir);

        if ($content) {
            foreach ($content as $value) {
                $path = $dir . $value;
                if (is_file($path)) {
                    $files[$value] = $path;
                }
            }
        }

        return $files;
    }
}

if(!function_exists('csrf_token')) {

    function csrf_token(): string
    {
        $token = Security::generateCSRFTtoken();

        $input = <<<HTML
            <input type="hidden" name="csrf_token" value=$token />
        HTML;

        return $input;
    }
}

if (!function_exists('validate')) {
    function validate(array $data, array $rules)
    {
        return Validator::validate($data, $rules);
    }
}

if (!function_exists('app_root_path')) {
    function app_root_path(string $path = "")
    {

        return Application::getAppDirectory() . $path;
    }
}

if (!function_exists('app_path')) {
    function app_path(string $path = "")
    {

        return app_root_path("/app/$path");
    }
}

if (!function_exists('app_http_path')) {
    function app_http_path(string $path = "")
    {

        return app_path("Http/$path");
    }
}
if (!function_exists('app_services_path')) {
    function app_services_path(string $path = "")
    {

        return app_path("Services/$path");
    }
}

if (!function_exists('app_view_path')) {
    function app_view_path(string $path = "")
    {

        return app_root_path("/views/$path");
    }
}

if (!function_exists('app_resources_path')) {
    function app_resources_path(string $path = "")
    {

        return app_root_path("/resources/$path");
    }
}

if (!function_exists('app_config_path')) {
    function app_config_path(string $path = "")
    {

        return app_root_path("/config/$path");
    }
}

if (!function_exists('app_cache_path')) {
    function app_cache_path(string $path = "")
    {

        return app_storage_path("/framework/cache/$path");
    }
}

if (!function_exists('app_storage_path')) {
    function app_storage_path(string $path = "")
    {

        return app_root_path("/storage/$path");
    }
}

if (!function_exists('app_routes_path')) {
    function app_routes_path(string $path = "")
    {

        return app_root_path("/routes/$path");
    }
}

if (!function_exists('core_root_path')) {
    function core_root_path(string $path = '')
    {

        return Application::$core_dir . $path;
    }
}

if (!function_exists('core_services_path')) {
    function core_services_path(string $path = "")
    {

        return core_root_path("/Services/$path");
    }
}
