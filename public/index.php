<?php

session_start();

defined('DIR_ROOT') or define('DIR_ROOT', dirname(__FILE__, 2));

require DIR_ROOT . '/bootstrap/app.php';

$router = new App\Http\Router(APP_URL);

foreach (glob(DIR_ROOT . '/routes/*.php') as $filename) {
  include $filename;
}

$router->run()->send();
