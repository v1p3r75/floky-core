<?php

namespace Floky\Facades;

use Dotenv\Dotenv;
use Floky\Exceptions\NotFoundException;

class Config extends Facades
{


    public static function get(string $file)
    {

        $file = $file . ".php";
        $config_files = get_directory_files(app_config_path());

        if (array_key_exists($file, $config_files)) {

            return require $config_files[$file];
        }

        throw new NotFoundException("'$file' file does not exist in config directory.");
    }


    public static function getEnv(string $key, string $default = null)
    {

        return isset($_ENV[$key]) ? $_ENV[$key] : $default;
    }

    public static function loadEnv(string $root_dir): bool
    {

        $dotenv = Dotenv::createImmutable($root_dir);
        $dotenv->safeLoad();

        return true;
    }
}
