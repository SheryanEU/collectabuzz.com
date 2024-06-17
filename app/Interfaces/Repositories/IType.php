<?php

namespace App\Interfaces\Repositories;

use App\Dto\Type;

interface IType
{
    public function create(Type $type): Type;
}
