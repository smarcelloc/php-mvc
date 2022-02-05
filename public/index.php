<?php

defined('DIR_ROOT') or define('DIR_ROOT', dirname(__FILE__, 2));

require DIR_ROOT . '/vendor/autoload.php';

$router = new App\Http\Router('http://localhost:8080');

foreach (glob(DIR_ROOT . '/routes/*.php') as $filename) {
  include $filename;
}

$router->run()->send();
