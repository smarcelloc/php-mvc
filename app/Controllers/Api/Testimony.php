<?php

namespace App\Controllers\Api;

use App\Http\Request;
use App\Http\Response;
use App\Models\Repositories\TestimonyRepository;
use App\Utils\Pagination;
use Exception;

class Testimony
{
    public static function index(Request $request)
    {
        $page = $request->getParams('page', 1);
        $limit = $request->getParams('limit', 10);

        $count = TestimonyRepository::getAllCount();
        $pagination = new Pagination($count, $page, $limit);
        $testimonials = TestimonyRepository::getAll($pagination->getLimit(), $pagination->getOffset());

        $data = [
            'testimonials' => $testimonials,
            'user' => $request->user,
            'pagination' => [
                'pageCurrent' => $pagination->getCurrentPage(),
                'pageTotal' => $pagination->getTotalPage()
            ]
        ];

        return new Response(200, $data, RESPONSE_JSON);
    }

    public static function query(int $id)
    {
        $data = TestimonyRepository::getByID($id);

        if (empty($data)) {
            throw new Exception("Not Found testimony", 404);
        }

        return new Response(200, $data, RESPONSE_JSON);
    }

    public static function create(Request $request)
    {
        $data = [
            'name' => $request->getPosts('name'),
            'message' => $request->getPosts('message')
        ];

        $id = TestimonyRepository::insert($data);

        $testimony = array_merge(['id' => $id], $data);
        return new Response(201, $testimony, RESPONSE_JSON);
    }

    public static function destroy(int $id)
    {
        TestimonyRepository::delete($id);
        return new Response(200, ['message' => 'Successfully deleted Testimony'], RESPONSE_JSON);
    }

    public static function update(int $id, Request $request)
    {
        $user = TestimonyRepository::getByID($id);
        if (!$user) {
            throw new Exception("Not Found", 404);
        }

        $posts = array_merge($user, $request->getPosts());

        $data = [
            'name' => $posts['name'],
            'message' => $posts['message']
        ];

        TestimonyRepository::update($id, $data);
        return new Response(200, ['message' => 'Successfully deleted Testimony'], RESPONSE_JSON);
    }
}
