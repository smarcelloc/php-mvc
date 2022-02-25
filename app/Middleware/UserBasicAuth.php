<?php

namespace App\Middleware;

use App\Contracts\Middleware;
use App\Http\Request;
use App\Http\Response;
use App\Models\Repositories\UserRepository;
use Closure;
use Exception;

class UserBasicAuth implements Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $this->getBasicAuthUser();
        if (!$user) {
            throw new Exception("invalid user", 403);
        }

        $request->user = $user;

        return $next($request);
    }

    private function getBasicAuthUser()
    {
        if (empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW'])) {
            return false;
        }

        $email = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];

        return UserRepository::authenticated($email, $password);
    }
}
