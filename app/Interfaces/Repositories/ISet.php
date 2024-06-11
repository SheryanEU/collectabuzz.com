<?php

namespace App\Interfaces\Repositories;

use App\Dto\Set;

interface ISet
{
    public function create(Set $series): Set;
}
