<?php

namespace App\Middleware;

use App\Contracts\Middleware;
use App\Http\Request;
use App\Http\Response;
use Closure;

class Maintenance implements Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (APP_MAINTENANCE == true) {
            return new Response(200, 'The site is under maintenance, please try again later.');
        }

        return $next($request);
    }
}
