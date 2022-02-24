<?php

defined('DIR_ROOT') or define('DIR_ROOT', dirname(__FILE__, 2));

require DIR_ROOT . '/bootstrap/app.php';

App\Http\Router::load(APP_URL);

foreach (glob(DIR_ROOT . '/routes/*.php') as $filename) {
  include $filename;
}

App\Http\Router::run()->send();
