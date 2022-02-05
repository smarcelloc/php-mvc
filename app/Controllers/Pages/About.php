<?php

namespace App\Controllers\Pages;

use App\Utils\View;

class About
{
  public static function index()
  {
    return View::template('layouts/main/index', 'pages/about', [
      'title' => 'About'
    ]);
  }
}
