<?php

namespace App\Controllers\Error;

use App\Http\Response;
use App\Utils\View;
use Exception;

class Pages
{
    public static function index(int $code, Exception $ex)
    {
        $content = View::pageWithLayout('/layouts/main/index', '/errors/page', [
            'title' => "Error $code",
            'code' => $code,
            'message' => $ex->getMessage()
        ]);

        return new Response($code, $content);
    }
}
