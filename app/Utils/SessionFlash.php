<?php

namespace App\Utils;

class SessionFlash
{
    private static $flashKey = 'flash';

    public static function get(string $key, mixed $defaultValue = null)
    {
        if (!self::isExist($key)) {
            return $defaultValue;
        }

        $session = $_SESSION[self::$flashKey][$key];
        self::unset($key);

        return $session;
    }

    public static function set(string $key, mixed $value)
    {
        $_SESSION[self::$flashKey][$key] = $value;
    }

    public static function isExist(string $key)
    {
        return isset($_SESSION[self::$flashKey][$key]);
    }

    public static function unset(string $key)
    {
        unset($_SESSION[self::$flashKey][$key]);
    }

    public static function destroy()
    {
        unset($_SESSION[self::$flashKey]);
    }
}
