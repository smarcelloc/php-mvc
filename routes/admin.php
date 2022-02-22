<?php

use App\Controllers\Admin;

$router->get('/admin', Admin\Home::index(...))->middleware(['auth_admin_login']);
$router->get('/admin/loggout', Admin\Home::logout(...));

$router->get('/admin/sign-in', Admin\SignIn::index(...))->middleware(['auth_admin_logout']);
$router->post('/admin/sign-in', Admin\SignIn::authenticated(...))->middleware(['auth_admin_logout']);

$router->get('/admin/sign-up', Admin\SignUp::index(...))->middleware(['auth_admin_logout']);
$router->post('/admin/sign-up', Admin\SignUp::createAccount(...))->middleware(['auth_admin_logout']);

$router->get('/admin/testimonial', Admin\Testimony::index(...))->middleware(['auth_admin_login']);
$router->get('/admin/users', Admin\User::index(...))->middleware(['auth_admin_login']);
