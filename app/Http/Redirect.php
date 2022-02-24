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
    self::temporary($uri);
  }

  public static function go(string $uri, int $code)
  {
    header("Location:" . APP_URL . $uri, response_code: $code);
    exit(0);
  }
}
