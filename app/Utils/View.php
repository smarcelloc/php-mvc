<?php

namespace App\Utils;

class View
{
  public static function render(string $view, array $vars = [])
  {
    extract($vars);

    ob_start();
    include DIR_VIEW . '/' . $view . '.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
  }

  public static function template(string $layout, string $view, array $vars = [])
  {
    $contentView = View::render($view, $vars);

    return View::render($layout, [
      'content' => $contentView,
      ...$vars
    ]);
  }
}
