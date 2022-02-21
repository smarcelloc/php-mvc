<?php

namespace App\Controllers\Admin;

use App\Http\Response;
use App\Utils\View;

class SignIn
{
    public static function index()
    {
        $content = View::pageWithLayout('layouts/login/index', 'admin/sign-in', [
            'title' => 'Sign In'
        ]);

        return new Response(200, $content);
    }
}
