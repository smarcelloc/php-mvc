<?php

namespace App\Models\Repositories;

use App\Models\Entities\User;

class UserRepository
{
    public static function insert(array $data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $user = new User();
        $id = $user->insert($data);

        return $id;
    }

    public static function isAuthenticated(string $email, string $password)
    {
        $user = self::getByEmail($email);

        if (!$user) {
            return false;
        }

        return password_verify($password, $user['password']);
    }

    public static function getByEmail(string $email)
    {
        return (new User())->select()->where('email = ?', $email)->first();
    }
}
