<?php

namespace App\Interfaces\Services;

use App\Dto\Serie;

interface ISerie
{
    public function create(Serie $serie): Serie;
}
