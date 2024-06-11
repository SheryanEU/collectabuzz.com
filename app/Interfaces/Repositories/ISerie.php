<?php

namespace App\Interfaces\Repositories;

use App\Dto\Serie;

interface ISerie
{
    public function create(Serie $series): Serie;
}
