<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit64de7673bfd09d16f3e6cc5072bee5bd
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit64de7673bfd09d16f3e6cc5072bee5bd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit64de7673bfd09d16f3e6cc5072bee5bd::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit64de7673bfd09d16f3e6cc5072bee5bd::$classMap;

        }, null, ClassLoader::class);
    }
}
