<?php

use App\Controllers\Pages;

$router->get('/{id}/{action}', Pages\Home::index(...));
