<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite48e576509ed0e178ac5e101c86c2d41
{
    public static $files = array (
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static $classMap = array (
        'ColdTurkey\\ChiroQuiz\\ChiroQuiz' => __DIR__ . '/../..' . '/classes/class-chiro-quiz.php',
        'ColdTurkey\\ChiroQuiz\\ChiroQuiz_Admin' => __DIR__ . '/../..' . '/classes/class-chiro-quiz-admin.php',
        'ColdTurkey\\ChiroQuiz\\FrontDesk' => __DIR__ . '/../..' . '/classes/class-frontdesk.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite48e576509ed0e178ac5e101c86c2d41::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite48e576509ed0e178ac5e101c86c2d41::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite48e576509ed0e178ac5e101c86c2d41::$classMap;

        }, null, ClassLoader::class);
    }
}
