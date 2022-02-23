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

    public static function update(int $id, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'] . APP_KEY, PASSWORD_DEFAULT);
        }

        $user = new User();
        $user->where('id=?', $id)->update($data);
    }

    public static function authenticated(string $email, string $password): null|array
    {
        $user = self::getByEmail($email);

        if (!$user || !password_verify($password . APP_KEY, $user['password'])) {
            return null;
        }

        unset($user['password']);
        return $user;
    }

    public static function getByEmail(string $email)
    {
        $user = (new User())->select()->where('email = ?', $email)->first();
        return $user;
    }
}
