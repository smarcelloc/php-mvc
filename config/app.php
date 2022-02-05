<?php

use App\Utils\Env;

// APP
define('APP_NAME', Env::get('APP_NAME'));
define('APP_URL', Env::get('APP_URL', 'http://localhost:8080'));

// DIR
define('DIR_VIEW', DIR_ROOT . '/resources/views');
