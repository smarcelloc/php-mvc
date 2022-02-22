<?php

namespace App\Models\Repositories;

use App\Models\Entities\User;

class UserRepository
{
    public static function insert(array $data)
    {
        $data['password'] = password_hash($data['password'] . APP_KEY, PASSWORD_DEFAULT);

        $user = new User();
        $id = $user->insert($data);

        return $id;
    }

    public static function authenticated(string $email, string $password): null|array
    {
        $user = self::getByEmail($email);

        if (!$user || !password_verify($password . APP_KEY, $user['password'])) {
            return null;
        }

        return $user;
    }

    public static function getByEmail(string $email)
    {
        return (new User())->select()->where('email = ?', $email)->first();
    }
}
