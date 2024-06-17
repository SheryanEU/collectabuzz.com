<?php

declare(strict_types=1);

namespace App\Dto;

use App\Models\Subtype as SubtypeModel;

final class Subtype
{
    public function __construct(
        public string $name
    ) {}

    public static function fromModel(SubtypeModel $type): self
    {
        return new self(
            $type->name
        );
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
