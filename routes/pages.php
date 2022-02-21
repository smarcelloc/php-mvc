<?php

use App\Controllers\Pages;

$router->get('/', Pages\Home::index(...));
$router->get('/about', Pages\About::index(...))->middleware(['maintenance']);;

$router->get('/testimonials', Pages\Testimony::index(...));
$router->post('/testimonials', Pages\Testimony::store(...));
$router->get('/testimonials/delete/{id}', Pages\Testimony::destroy(...));
