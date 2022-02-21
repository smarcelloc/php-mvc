<?php

namespace App\Sessions;

use App\Utils\Session;

class AuthAdmin
{
    private static string $userKey = 'admin_user';

    public static function login(array $user)
    {
        Session::set(self::$userKey, $user);
    }

    public static function isLogged()
    {
        return !!self::getUser('id');
    }

    public static function getUser(?string $field = null, mixed $defaultValue = null)
    {
        $user = Session::get(self::$userKey);
        if (is_null($field)) {
            return $user;
        }

        return $user[$field] ?? $defaultValue;
    }

    public static function setUser(array $newUser)
    {
        $user = self::getUser();
        Session::set(self::$userKey, array_merge($user, $newUser));
    }

    public static function destroy()
    {
        Session::unset(self::$userKey);
    }
}
