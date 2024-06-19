<?php

declare(strict_types=1);

namespace App\Repositories\Attack;

use App\Dto\Attack as AttackDto;
use App\Interfaces\Repositories\IAttack;
use App\Models\Attack as AttackModel;
use App\Models\Type;

final readonly class Attack implements IAttack
{
    public function create(AttackDto $attack): AttackDto
    {
        $attackModel = AttackModel::firstOrCreate(
            [
                'name' => $attack->name,
            ],
            [
                'converted_energy_cost' => $attack->convertedEnergyCost ?? 0,
                'damage' => $attack->damage ?? null,
                'description' => $attack->text ?? '',
            ]
        );

        // Sync types with pivot table
        $typeIds = [];
        foreach ($attack->types as $typeDto) {
            $type = Type::firstOrCreate(['name' => $typeDto->name]);
            $typeIds[$type->id] = ['cost' => $typeDto->pivot->cost ?? 0];
        }
        $attackModel->types()->sync($typeIds);

        return $attackModel->toDto();
    }
}
