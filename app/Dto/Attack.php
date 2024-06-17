<?php

declare(strict_types=1);

namespace App\Dto;

use App\Models\Attack as AttackModel;

final class Attack
{
    public function __construct(
        public string $name,
        public ?int $convertedEnergyCost,
        public ?string $damage,
        public ?string $text,
        public array $types
    ) {}

    public static function fromModel(AttackModel $attack): self
    {
        $types = $attack->types->map(fn($type) => Type::fromModel($type))->toArray();

        return new self(
            $attack->name,
            $attack->converted_energy_cost,
            $attack->damage,
            $attack->text,
            $types
        );
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
