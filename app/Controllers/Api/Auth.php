<?php

namespace App\Controllers\Api;

use App\Http\Request;
use App\Http\Response;
use App\Models\Repositories\UserRepository;
use Exception;

use Firebase\JWT\JWT;

class Auth
{
    public static function generateToken(Request $request)
    {
        $email = $request->getPosts('email');
        $password = $request->getPosts('password');

        if (empty($email) || empty($password)) {
            throw new Exception("The email and password field are required", 400);
        }

        $user = UserRepository::authenticated($email, $password);

        if (empty($user)) {
            throw new Exception("User not found", 404);
        }

        $payload = [
            'id' => $user['id']
        ];

        $data = [
            'token' => JWT::encode($payload, APP_KEY, JWT_ALG),
        ];

        return new Response(201, $data, RESPONSE_JSON);
    }

    public static function me(Request $request)
    {
        return new Response(200, $request->user ?? [], RESPONSE_JSON);
    }
}
