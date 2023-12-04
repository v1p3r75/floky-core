<?php

namespace Floky\Facades;

use Dotenv\Dotenv;
use Floky\Exceptions\Code;
use Floky\Exceptions\NotFoundException;

class Config extends Facades
{


    public static function get(string $file)
    {

        $path = explode('.', $file);
        $file = $path[0] . ".php";
        $params = array_slice($path, 1);
        $config_files = self::getDirectoryFiles(app_config_path());

        if (array_key_exists($file, $config_files)) {

            if(!empty($params)) {

                $config = require $config_files[$file];

                foreach($params as $param)
                    $config = $config[$param];

                return $config;
            }
            
            return require $config_files[$file];
        }

        throw new NotFoundException("'$file' file does not exist in config directory.", Code::FILE_NOT_FOUND);
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

    public static function getDirectoryFiles(string $dir): array
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
