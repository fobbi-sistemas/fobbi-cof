<?php

namespace Src\Util;

class AppConfig
{

    private static $config;

    public static function get(string $chave, $default = null)
    {
        if (self::$config === null) {
            $caminho = APP_ROOT . '/config.php';
            self::$config = file_exists($caminho) ? require $caminho : [];
        }

        return self::$config[$chave] ?? $default;
    }
}

?>
