<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd558b8a10dcb1a89179e300776581940
{
    public static $prefixLengthsPsr4 = array (
        'm' => 
        array (
            'models\\' => 7,
        ),
        'c' => 
        array (
            'controllers\\' => 12,
        ),
        'S' => 
        array (
            'Svg\\' => 4,
            'Sabberworm\\CSS\\' => 15,
        ),
        'F' => 
        array (
            'FontLib\\' => 8,
        ),
        'D' => 
        array (
            'Dompdf\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/models',
        ),
        'controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/controllers',
        ),
        'Svg\\' => 
        array (
            0 => __DIR__ . '/..' . '/phenx/php-svg-lib/src/Svg',
        ),
        'Sabberworm\\CSS\\' => 
        array (
            0 => __DIR__ . '/..' . '/sabberworm/php-css-parser/src',
        ),
        'FontLib\\' => 
        array (
            0 => __DIR__ . '/..' . '/phenx/php-font-lib/src/FontLib',
        ),
        'Dompdf\\' => 
        array (
            0 => __DIR__ . '/..' . '/dompdf/dompdf/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Dompdf\\Cpdf' => __DIR__ . '/..' . '/dompdf/dompdf/lib/Cpdf.php',
        'HTML5_Data' => __DIR__ . '/..' . '/dompdf/dompdf/lib/html5lib/Data.php',
        'HTML5_InputStream' => __DIR__ . '/..' . '/dompdf/dompdf/lib/html5lib/InputStream.php',
        'HTML5_Parser' => __DIR__ . '/..' . '/dompdf/dompdf/lib/html5lib/Parser.php',
        'HTML5_Tokenizer' => __DIR__ . '/..' . '/dompdf/dompdf/lib/html5lib/Tokenizer.php',
        'HTML5_TreeBuilder' => __DIR__ . '/..' . '/dompdf/dompdf/lib/html5lib/TreeBuilder.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd558b8a10dcb1a89179e300776581940::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd558b8a10dcb1a89179e300776581940::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd558b8a10dcb1a89179e300776581940::$classMap;

        }, null, ClassLoader::class);
    }
}