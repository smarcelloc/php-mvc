<?php

namespace App\Models\Entities;

use App\Utils\Database\Entity;

class Testimony extends Entity
{
  public function __construct()
  {
    parent::__construct('testimonials');
    $this->createConnection();
  }
}
