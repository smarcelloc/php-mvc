<?php

namespace App\Controllers\Admin;

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

        $content = View::pageWithLayout('layouts/admin/index', 'admin/testimonials/index', [
            'title' => 'Testimonials',
            'testimonials' => $testimonials,
            'pagination' => $pagination,
        ]);

        return new Response(200, $content);
    }

    public static function destroy(int $id)
    {
        TestimonyRepository::delete($id);
        Redirect::permanently('/admin/testimonials');
    }

    public static function add()
    {
        $content = View::pageWithLayout('layouts/admin/index', 'admin/testimonials/save', [
            'title' => 'Testimony Add'
        ]);

        return new Response(200, $content);
    }

    public static function edit(int $id)
    {
        $testimony = TestimonyRepository::getByID($id);
        $content = View::pageWithLayout('layouts/admin/index', 'admin/testimonials/save', [
            'title' => 'Testimony Edit',
            'testimony' => $testimony
        ]);

        return new Response(200, $content);
    }

    public static function store(Request $request)
    {
        $data = [
            'name' => $request->getPosts('name'),
            'message' => $request->getPosts('message')
        ];

        TestimonyRepository::insert($data);
        Redirect::permanently('/admin/testimonials');
    }

    public static function update(Request $request)
    {
        $id = $request->getPosts('id');
        $data = [
            'name' => $request->getPosts('name'),
            'message' => $request->getPosts('message')
        ];

        TestimonyRepository::update($id, $data);
        Redirect::permanently('/admin/testimonials');
    }
}
