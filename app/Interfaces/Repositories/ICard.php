<?php

namespace App\Interfaces\Repositories;

use App\Dto\Card;

interface ICard
{
    public function create(Card $card): Card;
}
