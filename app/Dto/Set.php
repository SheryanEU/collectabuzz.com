<?php

declare(strict_types=1);

namespace App\Dto;

use App\Models\Set as SetModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class Set
{
    /**
     * @throws ValidationException
     */
    public function __construct(
        public int $serieId,
        public string $setId,
        public string $name,
        public ?string $slug,
        public ?string $setCode,
        public string $setNumber,
        public string $setTotal,
        public ?string $setMasterTotal,
        public Carbon $releaseDate,
        public null|string|UploadedFile $logoSrc,
        public null|string|UploadedFile $symbolSrc,
    )
    {
        $this->validate([
            'serie_id' => $this->serieId,
            'set_id' => $this->setId,
            'name' => $this->name,
            'slug' => $this->slug,
            'set_code' => $this->setCode,
            'set_number' => $this->setNumber,
            'set_total' => $this->setTotal,
            'set_master_total' => $this->setMasterTotal,
            'release_date' => $this->releaseDate,
            'logo_src' => $this->logoSrc,
            'symbol_src' => $this->symbolSrc,
        ]);
    }

    /**
     * @throws ValidationException
     */
    private function validate(array $data): void
    {
        Validator::make($data, [
            'serie_id' => 'required|int|exists:serie,id',
            'set_id' => 'required|string|max:255|min:2',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'set_code' => 'nullable|string|max:255',
            'set_number' => 'required|string|max:255',
            'set_total' => 'required|string|max:255',
            'set_master_total' => 'nullable|string|max:255',
            'release_date' => 'required|date',
            'logo_src' => 'nullable',
            'symbol_src' => 'nullable',
        ])->validate();
    }

    public static function fromModel(SetModel $set): self
    {
        return new self(
            $set->serie_id,
            $set->set_id,
            $set->name,
            $set->slug,
            $set->set_code,
            $set->set_number,
            $set->set_total,
            $set->set_master_total,
            Carbon::parse($set->release_date),
            $set->logo_src,
            $set->symbol_src
        );
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
