<?php

declare(strict_types=1);

namespace App\Repositories\Set;

use App\Dto\Set as SetDto;
use App\Interfaces\Repositories\ISet;
use App\Models\Set as SetModel;
use Illuminate\Support\Str;

final readonly class Set implements ISet
{

    public function create(SetDto $set): SetDto
    {
        $data = $set->toArray();

        if (is_null($data['slug'])) {
            $data['slug'] = $this->generateUniqueSlug($data['name']);
        }

        if (is_null($data['serieId'])) {
            $data['serieId'] = $data['name'];
        }

        $set = SetModel::firstOrCreate(
            [
                'serie_id' => $data['serieId'],
                'name' => $data['name'],
                'set_code' => $data['setCode'],
            ],
            [
                'serie_id' => $data['serieId'],
                'set_id' => $data['setId'],
                'slug' => $data['slug'],
                'set_number' => $data['setNumber'],
                'set_total' => $data['setTotal'],
                'set_master_total' => $data['setMasterTotal'],
                'release_date' => $data['releaseDate'],
                'logo_src' => $data['logoSrc'],
                'symbolSrc' => $data['symbolSrc'],
            ]
        );

        return $set->toDto();
    }

    private function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (SetModel::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
