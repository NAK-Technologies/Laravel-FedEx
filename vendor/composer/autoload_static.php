<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit712c59c2e2912bbcb0da39f768b12777
{
    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'NakTech\\Couriers\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'NakTech\\Couriers\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit712c59c2e2912bbcb0da39f768b12777::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit712c59c2e2912bbcb0da39f768b12777::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit712c59c2e2912bbcb0da39f768b12777::$classMap;

        }, null, ClassLoader::class);
    }
}
