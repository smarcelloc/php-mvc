<?php

namespace App\Models\Repositories;

use App\Models\Entities\Testimony;

class TestimonyRepository
{
  public static function getAll(int $limit, int $offset)
  {
    $testimony = new Testimony();
    return $testimony->order('id DESC')->limit($limit)->offset($offset)->get();
  }

  public static function getAllCount()
  {
    $testimony = new Testimony();
    return $testimony->order('id DESC')->count();
  }

  public static function delete(int $id)
  {
    $testimony = new Testimony();
    $testimony->where('id=?', $id)->delete();
  }

  public static function insert(array $data)
  {
    $testimony = new Testimony();
    $id = $testimony->insert($data);

    return $id;
  }

  public static function getSearch(string $value, int $limit, int $offset)
  {
    $testimony = new Testimony();
    return $testimony->whereLike('name LIKE "%?%"', $value)
      ->limit($limit)
      ->offset($offset)
      ->get();
  }

  public static function getSearchCount(string $value)
  {
    $testimony = new Testimony();
    return $testimony->whereLike('name LIKE "%?%"', $value)->count();
  }
}
