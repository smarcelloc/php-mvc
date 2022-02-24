<?php

namespace App\Controllers\Admin;

use App\Http\Redirect;
use App\Http\Response;
use App\Sessions\AuthAdmin;
use App\Utils\View;

class Home
{
    public static function index()
    {
        $content = View::pageWithLayout('layouts/admin/index', 'admin/home', ['title' => 'Home']);
        return new Response(200, $content);
    }

    public static function logout()
    {
        AuthAdmin::destroy();
        Redirect::permanently('/admin/login/sign-in');
    }
}
