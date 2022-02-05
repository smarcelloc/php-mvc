<?php

namespace App\Controllers\Pages;

use App\Http\Redirect;
use App\Models\Repositories\TestimonyRepository;
use App\Utils\View;

class Testimony
{
  public static function index()
  {
    return View::template('layouts/main/index', 'pages/testimony', [
      'title' => 'Testimonials',
      'testimonials' => TestimonyRepository::getAll(),
    ]);
  }

  public static function destroy(int $id)
  {
    TestimonyRepository::delete($id);
    Redirect::page('/testimonials');
  }
}
