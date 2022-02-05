<?php

namespace App\Controllers\Pages;

class Home
{
  public static function index(string $id, string $action)
  {
    return $id . $action;
  }
}
