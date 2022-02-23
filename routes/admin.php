<?php

use App\Controllers\Admin;

$router->get('/admin', Admin\Home::index(...))->middleware(['auth_admin_login']);
$router->get('/admin/loggout', Admin\Home::logout(...));

$router->get('/admin/sign-in', Admin\SignIn::index(...))->middleware(['auth_admin_logout']);
$router->post('/admin/sign-in', Admin\SignIn::authenticated(...))->middleware(['auth_admin_logout']);

$router->get('/admin/sign-up', Admin\SignUp::index(...))->middleware(['auth_admin_logout']);
$router->post('/admin/sign-up', Admin\SignUp::createAccount(...))->middleware(['auth_admin_logout']);

$router->get('/admin/testimonials', Admin\Testimony::index(...))->middleware(['auth_admin_login']);
$router->get('/admin/testimonials/add', Admin\Testimony::add(...))->middleware(['auth_admin_login']);
$router->post('/admin/testimonials/add', Admin\Testimony::store(...))->middleware(['auth_admin_login']);
$router->get('/admin/testimonials/update/{id}', Admin\Testimony::edit(...))->middleware(['auth_admin_login']);
$router->post('/admin/testimonials/update/{id}', Admin\Testimony::update(...))->middleware(['auth_admin_login']);
$router->get('/admin/testimonials/delete/{id}', Admin\Testimony::destroy(...))->middleware(['auth_admin_login']);

$router->get('/admin/user', Admin\User::index(...))->middleware(['auth_admin_login']);
$router->post('/admin/user', Admin\User::update(...))->middleware(['auth_admin_login']);
