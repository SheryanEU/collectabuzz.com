<?php

declare(strict_types=1);

namespace App\Repositories\Type;

use App\Dto\Type as TypeDto;
use App\Interfaces\Repositories\IType;
use App\Models\Type as TypeModel;

final readonly class Type implements IType
{
    public function create(TypeDto $type): TypeDto
    {
        $type = TypeModel::firstOrCreate(['name' => $type->name]);

        return $type->toDto();
    }
}
