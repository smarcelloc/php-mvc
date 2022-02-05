<?php

namespace App\Controllers\Pages;

use App\Utils\View;

class Home
{
  public static function index()
  {
    return View::render('pages/home', ['title' => 'ok']);
  }
}
