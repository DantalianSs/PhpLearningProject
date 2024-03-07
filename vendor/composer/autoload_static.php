<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9fa3d2541c8ec4a03c8dbd1473446174
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MyProject\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MyProject\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/MyProject',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Parsedown' => 
            array (
                0 => __DIR__ . '/..' . '/erusev/parsedown',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9fa3d2541c8ec4a03c8dbd1473446174::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9fa3d2541c8ec4a03c8dbd1473446174::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit9fa3d2541c8ec4a03c8dbd1473446174::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit9fa3d2541c8ec4a03c8dbd1473446174::$classMap;

        }, null, ClassLoader::class);
    }
}
