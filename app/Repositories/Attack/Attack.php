<?php

declare(strict_types=1);

namespace App\Repositories\Attack;

use App\Dto\Attack as AttackDto;
use App\Interfaces\Repositories\IAttack;
use App\Models\Attack as AttackModel;

final readonly class Attack implements IAttack
{
    public function create(AttackDto $attack): AttackDto
    {
        $attack = AttackModel::firstOrCreate(['name' => $attack->name]);

        return $attack->toDto();
    }
}
