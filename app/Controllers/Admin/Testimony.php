<?php

namespace App\Controllers\Admin;

use App\Http\Response;
use App\Utils\View;

class Testimony
{
    public static function index()
    {
        $content = View::pageWithLayout('/layouts/admin/index', '/admin/testimonial', ['title' => 'Testimonial']);
        return new Response(200, $content);
    }
}
