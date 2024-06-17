<?php

namespace App\Interfaces\Repositories;

use App\Dto\Pokemon;

interface IPokemon
{
    public function create(Pokemon $card): Pokemon;
}
