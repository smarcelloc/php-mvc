<?php

namespace App\Controllers\Error;

use App\Http\Redirect;
use App\Http\Response;
use App\Sessions\AuthAdmin as SessionAuthAdmin;
use App\Utils\View;
use Exception;

class Admin
{
    public static function index(int $code, Exception $ex)
    {
        if (!SessionAuthAdmin::isLogged()) {
            Redirect::permanently('/admin/login');
        }

        $content = View::pageWithLayout('/layouts/admin/index', '/errors/admin', [
            'title' => "Error $code",
            'code' => $code,
            'message' => $ex->getMessage()
        ]);

        return new Response($code, $content);
    }
}
