<?php

namespace App\Http;

class Redirect
{
  public static function page(string $uri, int $code = 302)
  {
    header("Location:" . APP_URL . $uri, response_code: $code);
    exit(0);
  }
}
