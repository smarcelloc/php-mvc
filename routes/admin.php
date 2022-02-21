<?php

use App\Controllers\Admin;

$router->get('/admin', Admin\Home::index(...))->middleware(['auth_admin']);

$router->get('/admin/sign-in', Admin\SignIn::index(...));
$router->post('/admin/sign-in', Admin\SignIn::authenticated(...));

$router->get('/admin/sign-up', Admin\SignUp::index(...));
$router->post('/admin/sign-up', Admin\SignUp::createAccount(...));
