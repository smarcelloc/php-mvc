<?php

namespace App\Utils;

class Session
{
    public static function set(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get(?string $key = null, mixed $defaultValue = null)
    {
        if (is_null($key)) {
            return $_SESSION;
        }

        return $_SESSION[$key] ?? $defaultValue;
    }

    public static function isExist(string $key)
    {
        return isset($_SESSION[$key]);
    }

    public static function unset(string $key)
    {
        unset($_SESSION[$key]);
    }

    public static function destroy()
    {
        unset($_SESSION);
    }
}
