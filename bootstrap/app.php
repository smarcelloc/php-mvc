<?php

use App\Middleware\Queue as MiddlewareQueue;

require DIR_ROOT . '/vendor/autoload.php';

App\Utils\Env::load(DIR_ROOT . '/.env');

foreach (glob(DIR_ROOT . '/config/*.php') as $filename) {
  require_once $filename;
}

MiddlewareQueue::setMap([
  'maintenance' => App\Middleware\Maintenance::class,
  'auth_admin_logout' => App\Middleware\AuthAdminLogout::class,
  'auth_admin_login' => App\Middleware\AuthAdminLogin::class
]);

MiddlewareQueue::setDefault([
  'maintenance'
]);
