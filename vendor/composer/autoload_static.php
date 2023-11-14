<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc413eeacf26c40d40da6a6e410d8408c
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Fried75\\FlokyCore\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Fried75\\FlokyCore\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc413eeacf26c40d40da6a6e410d8408c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc413eeacf26c40d40da6a6e410d8408c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc413eeacf26c40d40da6a6e410d8408c::$classMap;

        }, null, ClassLoader::class);
    }
}
