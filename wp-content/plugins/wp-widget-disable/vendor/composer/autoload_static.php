<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb8f92aeebd3e68a26d45a1994acec033
{
    public static $classMap = array (
        'WP_Requirements_Check' => __DIR__ . '/..' . '/wearerequired/wp-requirements-check/WP_Requirements_Check.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitb8f92aeebd3e68a26d45a1994acec033::$classMap;

        }, null, ClassLoader::class);
    }
}
