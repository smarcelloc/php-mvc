<?php

namespace App\Contracts;

use App\Http\Request;
use App\Http\Response;
use Closure;

interface Middleware
{
    public function handle(Request $request, Closure $next): Response;
}
