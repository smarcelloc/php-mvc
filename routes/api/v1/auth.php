<?php

use App\Controllers\Api;
use App\Http\Router;

Router::post('/api/v1/auth', Api\Auth::generateToken(...));

Router::middleware(['jwt_auth'])::group('/api/v1/auth', function () {
    Router::get('/me', Api\Auth::me(...));
    Router::get('/testimonials', Api\Testimony::index(...));
});
