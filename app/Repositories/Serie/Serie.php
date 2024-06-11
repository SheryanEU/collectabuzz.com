<?php

declare(strict_types=1);

namespace App\Repositories\Serie;

use App\Dto\Serie as SerieDto;
use App\Interfaces\Repositories\ISerie;
use App\Models\Serie as SerieModel;
use Illuminate\Support\Str;

final readonly class Serie implements ISerie
{

    public function create(SerieDto $serie): SerieDto
    {
        $data = $serie->toArray();

        if (is_null($data['slug'])) {
            $data['slug'] = $this->generateUniqueSlug($data['name']);
        }

        if (is_null($data['serie_id'])) {
            $data['serie_id'] = $data['name'];
        }

        $serie = SerieModel::firstOrCreate(
            ['serie_id' => $data['serie_id']],
            $data
        );

        return $serie->toDto();
    }

    private function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (SerieModel::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
