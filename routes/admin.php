<?php

use App\Controllers\Admin;
use App\Http\Redirect;
use App\Http\Router;

Router::middleware(['auth_admin_login'])::group('/admin', function () {
    Router::get('/', Admin\Home::index(...));
    Router::get('/loggout', Admin\Home::logout(...));

    Router::get('/testimonials', Admin\Testimony::index(...));
    Router::get('/testimonials/add', Admin\Testimony::add(...));
    Router::post('/testimonials/add', Admin\Testimony::store(...));
    Router::get('/testimonials/update/{id}', Admin\Testimony::edit(...));
    Router::post('/testimonials/update/{id}', Admin\Testimony::update(...));
    Router::get('/testimonials/delete/{id}', Admin\Testimony::destroy(...));

    Router::get('/user', Admin\User::index(...));
    Router::post('/user', Admin\User::update(...));
});

Router::middleware(['auth_admin_logout'])::group('/admin/login', function () {
    Router::get('/', function () {
        Redirect::page('/admin/login/sign-in');
    });

    Router::get('/sign-in', Admin\SignIn::index(...));
    Router::post('/sign-in', Admin\SignIn::authenticated(...));

    Router::get('/sign-up', Admin\SignUp::index(...));
    Router::post('/sign-up', Admin\SignUp::createAccount(...));
});
