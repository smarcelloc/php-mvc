<?php

namespace App\Controllers\Admin;

use App\Http\Redirect;
use App\Http\Request;
use App\Http\Response;
use App\Models\Repositories\UserRepository;
use App\Sessions\AuthAdmin;
use App\Utils\Session;
use App\Utils\View;

class User
{
    public static function index()
    {
        $user = AuthAdmin::getUser();
        if (!$user) {
            AuthAdmin::destroy();
            Redirect::permanently('/admin');
        }

        $content = View::pageWithLayout('layouts/admin/index', 'admin/user', [
            'title' => 'User',
            'user' => $user
        ]);

        return new Response(200, $content);
    }

    public static function update(Request $request)
    {
        $id = AuthAdmin::getUser('id');
        if (!$id) {
            AuthAdmin::destroy();
            Redirect::permanently('/admin');
        }

        $password = $request->getPosts('password');
        $data = [
            'name' => $request->getPosts('name'),
            'email' => $request->getPosts('email')
        ];

        if (!empty($password)) {
            $data = array_merge($data, ['password' => $password]);
        }

        UserRepository::update($id, $data);

        unset($data['password']);
        AuthAdmin::setUser($data);

        Redirect::permanently('/admin');
    }
}
