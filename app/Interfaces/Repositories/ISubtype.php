<?php

namespace App\Interfaces\Repositories;

use App\Dto\Subtype;

interface ISubtype
{
    public function create(Subtype $subtype): Subtype;
}
