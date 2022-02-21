<?php

namespace App\Controllers\Admin;

use App\Http\Redirect;
use App\Http\Request;
use App\Http\Response;
use App\Models\Repositories\UserRepository;
use App\Sessions\AuthAdmin as SessionAuthAdmin;
use App\Utils\SessionFlash;
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

        $user = UserRepository::authenticated($email, $password);
        if ($user) {
            SessionAuthAdmin::login($user);
            Redirect::page('/admin');
        }

        SessionFlash::set(ALERT_ERROR, ['message' => 'The system did not find this user.']);
        return self::index();
    }
}
