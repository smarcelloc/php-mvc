<?php

namespace App\Controllers\Admin;

use App\Http\Redirect;
use App\Http\Request;
use App\Http\Response;
use App\Models\Repositories\UserRepository;
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

    public static function authenticated(Request $request)
    {
        $email = $request->getPosts('email');
        $password = $request->getPosts('password');

        if (UserRepository::isAuthenticated($email, $password)) {
            Redirect::page('/admin');
        }

        return self::index();
    }
}
