<?php

namespace App\Controllers\Pages;

use App\Http\Response;
use App\Utils\View;

class Home
{
  public static function index()
  {
    $content = View::pageWithLayout('layouts/main/index', 'pages/home', [
      'title' => 'Home',
      'site_label' => 'Github',
      'site_url' => 'https://github.com/smarcelloc'
    ]);

    return new Response(200, $content);
  }
}
