<?php

namespace App\Middleware;

use App\Contracts\Middleware;
use App\Http\Redirect;
use App\Http\Request;
use App\Http\Response;
use App\Sessions\AuthAdmin as SessionAuthAdmin;
use Closure;

class AuthAdminLogin implements Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!SessionAuthAdmin::isLogged()) {
            Redirect::page('/admin/login');
        }

        return $next($request);
    }
}
