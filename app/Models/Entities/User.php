<?php

namespace App\Models\Entities;

use App\Utils\Database\Entity;

class User extends Entity
{
    public function __construct()
    {
        parent::__construct('Users');
    }
}
