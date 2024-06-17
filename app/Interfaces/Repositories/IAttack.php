<?php

namespace App\Interfaces\Repositories;

use App\Dto\Attack;

interface IAttack
{
    public function create(Attack $attack): Attack;
}
