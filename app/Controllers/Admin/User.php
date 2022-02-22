<?php

namespace App\Controllers\Admin;

use App\Http\Response;
use App\Utils\View;

class User
{
    public static function index()
    {
        $content = View::pageWithLayout('/layouts/admin/index', '/admin/users', ['title' => 'Users']);
        return new Response(200, $content);
    }
}
