<?php

namespace App\Http;

class Redirect
{
  public static function permanently(string $uri)
  {
    self::go($uri, 301);
  }

  public static function temporary(string $uri)
  {
    self::temporary($uri, 307);
  }

  public static function go(string $uri, int $code)
  {
    header("Location:" . APP_URL . $uri, false, $code);
    exit(0);
  }
}
