<?php

namespace App\Controllers\Error;

use App\Http\Response;
use Exception;

class Api
{
    public static function index(int $code, Exception $ex)
    {
        $data = [
            'code' => $code,
            'message' => $ex->getMessage()
        ];

        return new Response($code, $data, RESPONSE_JSON);
    }
}
