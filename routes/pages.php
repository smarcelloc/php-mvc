<?php

use App\Controllers\Pages;

$router->get('/', Pages\Home::index(...));
$router->get('/about', Pages\About::index(...));
