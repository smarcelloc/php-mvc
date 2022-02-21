<?php

namespace App\Controllers\Admin;

use App\Http\Redirect;
use App\Http\Request;
use App\Http\Response;
use App\Models\Repositories\UserRepository;
use App\Utils\View;

class SignUp
{
    public static function index()
    {
        $content = View::pageWithLayout('layouts/login/index', 'admin/sign-up', [
            'title' => 'Sign Up'
        ]);

        return new Response(200, $content);
    }

    public static function createAccount(Request $request)
    {
        $data = [
            'name' => $request->getPosts('name'),
            'email' => $request->getPosts('email'),
            'password' => $request->getPosts('password')
        ];

        UserRepository::insert($data);

        Redirect::page('/admin/sign-in');
    }
}
