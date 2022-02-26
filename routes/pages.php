<?php

use App\Controllers\Pages;
use App\Http\Router;

Router::get('/', Pages\Home::index(...));

Router::group('/testimonials', function () {
    Router::middleware(['cache'])::get('/', Pages\Testimony::index(...));
    Router::post('/', Pages\Testimony::store(...));
    Router::get('/delete/{id}', Pages\Testimony::destroy(...));
});

Router::get('/about', Pages\About::index(...));
