<?php

namespace App\Interfaces\Services;

use App\Dto\Card;

interface ICard
{
    public function create(Card $card): Card;
}
