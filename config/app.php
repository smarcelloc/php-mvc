<?php

use App\Utils\Env;

// APP
define('APP_NAME', Env::get('APP_NAME'));

$urlDynamic = "{$_SERVER['REQUEST_SCHEME']}//:{$_SERVER['HTTP_HOST']}";
define('APP_URL', rtrim(Env::get('APP_URL', $urlDynamic), '/'));

define('APP_MAINTENANCE', Env::get('APP_MAINTENANCE', false));

define('APP_KEY', Env::required('APP_KEY'));
define('JWT_ALG', 'HS256');

// DIR
define('DIR_VIEW', DIR_ROOT . '/resources/views');
