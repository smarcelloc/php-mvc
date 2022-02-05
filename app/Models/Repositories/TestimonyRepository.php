<?php

namespace App\Models\Repositories;

use App\Models\Entities\Testimony;

class TestimonyRepository
{
  public static function getAll()
  {
    $testimony = new Testimony();
    return $testimony->order('id DESC')->get();
  }

  public static function delete(int $id)
  {
    $testimony = new Testimony();
    $testimony->where('id=?', $id)->delete();
  }
}
