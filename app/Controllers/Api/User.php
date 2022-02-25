<?php

namespace App\Controllers\Api;

use App\Http\Request;
use App\Http\Response;
use App\Models\Repositories\UserRepository;
use Exception;

class User
{
    public static function index(Request $request)
    {
        if (empty($request->user)) {
            throw new Exception("Not found", 404);
        }

        return new Response(200, $request->user, RESPONSE_JSON);
    }

    public static function update(Request $request)
    {
        if (empty($request->user)) {
            throw new Exception("Not found", 404);
        }

        $user = array_merge($request->user, $request->getPosts());
        $data = [
            'name' => $user['name'],
            'email' => $user['email'],
        ];

        if (isset($user['password'])) {
            $data = array_merge($data, ['password' => $user['password']]);
        }

        UserRepository::update($request->user['id'], $data);
        return new Response(200, ['message' => 'User successfully updated'], RESPONSE_JSON);
    }
}
