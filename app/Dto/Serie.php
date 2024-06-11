<?php

declare(strict_types=1);

namespace App\Dto;

use App\Models\Serie as SerieModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class Serie
{
    /**
     * @throws ValidationException
     */
    public function __construct(
        public ?string $serieId = null,
        public string $name,
        public ?string $slug = null,
        public ?string $description,
        public null|string $hexadecimalcolor,
        public null|string|UploadedFile $logoSrc
    ) {
        $this->validate([
            'serie_id' => $this->serieId,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'hexadecimalcolor' => $this->hexadecimalcolor,
            'logo_src' => $this->logoSrc,
        ]);
    }

    /**
     * @throws ValidationException
     */
    private function validate(array $data): void
    {
        Validator::make($data, [
            'serie_id' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'hexadecimalcolor' => 'nullable|string|max:7',
            'logo_src' => 'nullable',
        ])->sometimes('logo_src', 'file', function ($input) {
            return $input['logo_src'] instanceof UploadedFile;
        })->validate();
    }

    public static function fromModel(SerieModel $serie): self
    {
        return new self(
            $serie->serie_id ?? null,
            $serie->name,
            $serie->slug ?? null,
            $serie->description ?? null,
            $serie->hexadecimalcolor ?? null,
            $serie->logo_src ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'serie_id' => $this->serieId,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'hexadecimalcolor' => $this->hexadecimalcolor,
            'logo_src' => $this->logoSrc,
        ];
    }
}
