<?php

namespace App\Controllers\Pages;

use App\Http\Redirect;
use App\Http\Request;
use App\Models\Repositories\TestimonyRepository;
use App\Utils\View;

class Testimony
{
  public static function index(Request $request)
  {
    $search = $request->getParams('search');
    $testimonials = [];

    if (!empty($search)) {
      $testimonials = TestimonyRepository::getSearch($search);
    } else {
      $testimonials = TestimonyRepository::getAll();
    }

    return View::template('layouts/main/index', 'pages/testimony', [
      'title' => 'Testimonials',
      'testimonials' => $testimonials,
    ]);
  }

  public static function destroy(int $id)
  {
    TestimonyRepository::delete($id);
    Redirect::page('/testimonials');
  }

  public static function store(Request $request)
  {
    $data = [
      'name' => $request->getPosts('name'),
      'message' => $request->getPosts('message')
    ];

    TestimonyRepository::insert($data);
    Redirect::page('/testimonials');
  }
}
