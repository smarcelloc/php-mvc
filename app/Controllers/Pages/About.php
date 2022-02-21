<?php

namespace App\Controllers\Pages;

use App\Http\Response;
use App\Utils\View;

class About
{
  public static function index()
  {
    $content = View::pageWithLayout('layouts/main/index', 'pages/about', [
      'title' => 'About'
    ]);

    return new Response(200, $content);
  }
}
