<?php

use App\Controllers\Admin;

$router->get('/admin', Admin\Home::index(...));
$router->get('/admin/sign-in', Admin\SignIn::index(...));
