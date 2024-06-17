<?php

declare(strict_types=1);

namespace App\Repositories\Pokemon;

use App\Dto\Card as CardDto;
use App\Interfaces\Repositories\ICard;
use App\Interfaces\Repositories\IPokemon;
use App\Models\Card as CardModel;
use App\Models\Serie as SerieModel;
use Illuminate\Support\Str;

final readonly class Pokemon implements IPokemon
{
    public function create(\App\Dto\Pokemon $card): \App\Dto\Pokemon
    {
        // TODO: Implement create() method.
    }
}
