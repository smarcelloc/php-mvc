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
}
