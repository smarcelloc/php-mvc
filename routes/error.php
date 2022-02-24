<?php

use App\Http\Router;
use App\Controllers\Error;

Router::setErrors([
    '/*' => Error\Pages::index(...),
    '/api/*' => Error\Api::index(...),
    '/admin/*' => Error\Admin::index(...),
]);
