<?php

namespace App\Utils;

class SessionFlash
{
    private static $flashKey = 'flash';

    public static function get(?string $key = null, mixed $defaultValue = null)
    {
        if (is_null($key)) {
            $sessions = $_SESSION;
            self::destroy();

            return $sessions;
        }

        if (self::isExist($key)) {
            $session = $_SESSION[self::$flashKey][$key];
            self::unset($key);

            return $session;
        }

        return $defaultValue;
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
