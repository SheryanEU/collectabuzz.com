<?php

declare(strict_types=1);

namespace App\Dto;

use App\Models\Attack as AttackModel;

final class Weakness
{
    public function __construct(
        public Type $type,
        public int $value
    ) {}

    public static function fromArray(array $data): self
    {
        if ($data['type'] instanceof Type) {
            return new self(
                $data['type'],
                $data['value']
            );
        }

        return new self(
            Type::fromModel($data['type']),
            $data['value']
        );
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
