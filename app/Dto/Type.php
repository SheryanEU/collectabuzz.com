<?php

declare(strict_types=1);

namespace App\Dto;

use App\Models\Type as TypeModel;

final class Type
{
    public function __construct(
        public string $name
    ) {}

    public static function fromModel(TypeModel $type): self
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
