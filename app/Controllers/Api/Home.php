<?php

namespace App\Controllers\Api;

use App\Http\Response;

class Home
{
    public static function index()
    {
        $data = [
            'name' => APP_NAME,
            'version' => 'v1.0.0'
        ];

        return new Response(200, $data, RESPONSE_JSON);
    }
}
