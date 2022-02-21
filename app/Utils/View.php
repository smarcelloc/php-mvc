<?php

namespace App\Utils;

class View
{
  public static function pageWithLayout(string $layout, string $view, array $vars = [])
  {
    $contentView = self::render($view, $vars);

    return self::render($layout, [
      'content' => $contentView,
      ...$vars
    ]);
  }

  public static function page(string $view, array $vars)
  {
    return self::render($view, $vars);
  }

  private static function render(string $view, array $vars = [])
  {
    extract($vars);

    ob_start();
    include DIR_ROOT . '/resources/views' . '/' . $view . '.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
  }
}
