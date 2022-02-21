<?php

namespace App\Controllers\Admin;

use App\Http\Response;

class Home
{
    public static function index()
    {
        return new Response(200, 'admin');
    }
}
