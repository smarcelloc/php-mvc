<?php

namespace App\Middleware;

use App\Contracts\Middleware;
use App\Http\Request;
use App\Http\Response;
use App\Models\Repositories\UserRepository;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Throwable;

class JwtAuth implements Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $this->getJWTAuthUser($request);
        if (!$user) {
            throw new Exception("Access denied", 403);
        }

        $request->user = $user;

        return $next($request);
    }

    private function getJWTAuthUser(Request $request)
    {
        try {
            $authorization = $request->getHeaders('authorization');
            $token = str_replace('Bearer ', '', $authorization);
            $decoded = (array) JWT::decode($token, new Key(APP_KEY, JWT_ALG));
            return UserRepository::getById($decoded['id']);
        } catch (Throwable $ex) {
            return false;
        }
    }
}
