<?php

namespace App\Interfaces\Services;

use App\Dto\Set;

interface ISet
{
    public function create(Set $set): Set;
}
