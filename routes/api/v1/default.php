<?php

use App\Controllers\Api;
use App\Http\Router;

include __DIR__ . '/auth.php';

Router::group('/api/v1', function () {
    Router::get('/', Api\Home::index(...));
});

Router::middleware(['user_basic_auth'])::group('/api/v1', function () {
    Router::get('/', Api\Home::index(...));

    Router::middleware(['cache'])::get('/testimonials', Api\Testimony::index(...));
    Router::get('/testimonials/{id}', Api\Testimony::query(...));
    Router::post('/testimonials', Api\Testimony::create(...));
    Router::delete('/testimonials/{id}', Api\Testimony::destroy(...));
    Router::patch('/testimonials/{id}', Api\Testimony::update(...));

    Router::get('/user', Api\User::index(...));
    Router::patch('/user', Api\User::update(...));
});
