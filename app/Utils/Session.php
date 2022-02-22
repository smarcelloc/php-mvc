<?php

namespace App\Utils;

class Session
{
    public static function set(string $key, mixed $value)
    {
        $valueToString = json_encode($value);
        $_SESSION[$key] = Crypt::encrypt($valueToString);
    }

    public static function get(string $key, mixed $defaultValue = null, bool $associative = true)
    {
        if (!self::isExist($key)) {
            return $defaultValue;
        }

        $hash = $_SESSION[$key];
        $value = Crypt::decrypt($hash);

        return json_decode($value, $associative);
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
