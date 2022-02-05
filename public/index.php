<?php

defined('DIR_ROOT') or define('DIR_ROOT', dirname(__FILE__, 2));

require DIR_ROOT . '/vendor/autoload.php';

App\Utils\Env::load(DIR_ROOT . '/.env');

foreach (glob(DIR_ROOT . '/config/*.php') as $filename) {
  require_once $filename;
}

$router = new App\Http\Router(APP_URL);

foreach (glob(DIR_ROOT . '/routes/*.php') as $filename) {
  include $filename;
}

$router->run()->send();
