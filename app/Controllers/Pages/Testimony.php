<?php

namespace App\Controllers\Pages;

use App\Http\Redirect;
use App\Http\Request;
use App\Http\Response;
use App\Models\Repositories\TestimonyRepository;
use App\Utils\Pagination;
use App\Utils\View;

class Testimony
{
  public static function index(Request $request)
  {
    $search = $request->getParams('search');
    $page = $request->getParams('page', 1);
    $testimonials = [];

    if (!empty($search)) {
      $count = TestimonyRepository::getSearchCount($search);
      $pagination = new Pagination($count, $page);
      $testimonials = TestimonyRepository::getSearch(
        $search,
        $pagination->getLimit(),
        $pagination->getOffset()
      );
    } else {
      $count = TestimonyRepository::getAllCount($search);
      $pagination = new Pagination($count, $page);
      $testimonials = TestimonyRepository::getAll(
        $pagination->getLimit(),
        $pagination->getOffset()
      );
    }

    $content = View::pageWithLayout('layouts/main/index', 'pages/testimony', [
      'title' => 'Testimonials',
      'testimonials' => $testimonials,
      'pagination' => $pagination,
    ]);

    return new Response(200, $content);
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
