<?php

use App\Controllers\Api;
use App\Http\Router;

Router::group('/api/v1', function () {
    Router::get('/', Api\Home::index(...));
});

Router::middleware(['user_basic_auth'])::group('/api/v1', function () {
    Router::get('/', Api\Home::index(...));

    Router::get('/testimonials', Api\Testimony::index(...));
    Router::get('/testimonials/{id}', Api\Testimony::query(...));
    Router::post('/testimonials', Api\Testimony::create(...));
    Router::delete('/testimonials/{id}', Api\Testimony::destroy(...));
    Router::patch('/testimonials/{id}', Api\Testimony::update(...));
});
