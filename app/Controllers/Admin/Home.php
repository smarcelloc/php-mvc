<?php

namespace App\Controllers\Admin;

use App\Http\Redirect;
use App\Http\Response;
use App\Sessions\AuthAdmin;

class Home
{
    public static function index()
    {
        return new Response(200, 'admin');
    }

    public static function logout()
    {
        AuthAdmin::destroy();
        Redirect::page('/admin/sign-in');
    }
}
