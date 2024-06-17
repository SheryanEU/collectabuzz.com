<?php

declare(strict_types=1);

namespace App\Repositories\Subtype;

use App\Dto\Subtype as SubtypeDto;
use App\Interfaces\Repositories\ISubtype;
use App\Models\Subtype as SubtypeModel;

final readonly class Subtype implements ISubtype
{
    public function create(SubtypeDto $subtype): SubtypeDto
    {
        $subtype = SubtypeModel::firstOrCreate(['name' => $subtype->name]);

        return $subtype->toDto();
    }
}
