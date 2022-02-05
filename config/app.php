<?php

use App\Utils\Env;

// APP
define('APP_NAME', Env::get('APP_NAME'));

$urlDynamic = "{$_SERVER['REQUEST_SCHEME']}//:{$_SERVER['HTTP_HOST']}";
define('APP_URL', rtrim(Env::get('APP_URL', $urlDynamic), '/'));

// DIR
define('DIR_VIEW', DIR_ROOT . '/resources/views');
