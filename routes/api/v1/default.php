<?php

use App\Controllers\Api;
use App\Http\Router;

Router::group('/api/v1', function () {
    Router::get('/', Api\Home::index(...));

    Router::get('/testimonials', Api\Testimony::index(...));
    Router::get('/testimonials/{id}', Api\Testimony::query(...));
});
