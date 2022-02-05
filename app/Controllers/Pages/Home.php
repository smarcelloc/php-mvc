<?php

namespace App\Controllers\Pages;

use App\Utils\View;

class Home
{
  public static function index()
  {
    return View::template('layouts/main/index', 'pages/home', [
      'title' => 'Home',
      'site_label' => 'Github',
      'site_url' => 'https://github.com/smarcelloc'
    ]);
  }
}
