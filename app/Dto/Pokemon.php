<?php

declare(strict_types=1);

namespace App\Dto;

use App\Models\Pokemon as PokemonDTO;

final class Pokemon
{
    /**
     * @throws ValidationException
     */
    public function __construct(
        public int $number,
        public string $name,
        public int $generation,
        public string $status,
        public string $species,
        public string $primaryType,
        public ?string $secondaryType,
        public int $height,
        public int $weight,
        public ?string $primaryAbility,
        public ?string $secondaryAbility,
        public ?string $hiddenAbility,
        public int $healthPoints,
        public int $attack,
        public int $defence,
        public int $spAttack,
        public int $spDefense,
    ) {}

    public static function fromModel(PokemonDTO $pokemon): self
    {
        return new self(
            $pokemon->number,
            $pokemon->name,
            $pokemon->generation,
            $pokemon->status,
            $pokemon->species,
            $pokemon->primary_type,
            $pokemon->secondary_type,
            $pokemon->height,
            $pokemon->weight,
            $pokemon->primary_ability,
            $pokemon->secondary_ability,
            $pokemon->hidden_ability,
            $pokemon->health_points,
            $pokemon->attack,
            $pokemon->defence,
            $pokemon->sp_attack,
            $pokemon->sp_defense,
        );
    }

    public function toArray(): array
    {
        return [
            'number' => $this->number,
            'name' => $this->name,
            'generation' => $this->generation,
            'status' => $this->status,
            'species' => $this->species,
            'primaryType' => $this->primaryType,
            'secondaryType' => $this->secondaryType,
            'height' => $this->height,
            'weight' => $this->weight,
            'primaryAbility' => $this->primaryAbility,
            'secondaryAbility' => $this->secondaryAbility,
            'hiddenAbility' => $this->hiddenAbility,
            'healthPoints' => $this->healthPoints,
            'attack' => $this->attack,
            'defence' => $this->defence,
            'spAttack' => $this->spAttack,
            'spDefense' => $this->spDefense,
        ];
    }
}
