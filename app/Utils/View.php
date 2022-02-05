<?php

namespace App\Utils;

class View
{
  public static function render(string $view, array $vars = [])
  {
    extract($vars);

    ob_start();
    include DIR_ROOT . '/resources/views/' . $view . '.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
  }
}
