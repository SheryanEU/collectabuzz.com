<?php

declare(strict_types=1);

namespace App\Services\Serie;

use App\Dto\Serie as SerieDto;
use App\Interfaces\Services\ISerie;
use App\Repositories\Serie\Serie as SerieRepository;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final readonly class Serie implements ISerie
{
    public function __construct(
        protected SerieRepository $serieRepository
    ) {}

    public function create(SerieDto $serie): SerieDto
    {
        $serie = $this->handleLogoSrc($serie);

        return $this->serieRepository->create($serie);
    }

    /**
     * @throws Exception
     */
    private function handleLogoSrc(SerieDto $serie): SerieDto
    {
        $fileNameBase = Str::slug($serie->name, '_');
        $directory = 'public/serie/logo';
        $path = "$directory/$fileNameBase";

        if ($serie->logoSrc instanceof UploadedFile) {
            $extension = $serie->logoSrc->getClientOriginalExtension();
            $fullPath = "$path.$extension";

            if (!Storage::exists($fullPath)) {
                $path = $serie->logoSrc->storeAs($directory, "$fileNameBase.$extension");
            }

            $serie->logoSrc = Storage::url($fullPath);
        } elseif (
            filter_var($serie->logoSrc, FILTER_VALIDATE_URL)
        ) {
            $extension = pathinfo($serie->logoSrc, PATHINFO_EXTENSION);
            $fullPath = "$path.$extension";

            if (!Storage::exists($fullPath)) {
                $contents = file_get_contents($serie->logoSrc);
                Storage::put($fullPath, $contents);
            }

            $serie->logoSrc = Storage::url($fullPath);
        } elseif (
            $serie->logoSrc !== null
            && !File::exists(storage_path("app/$directory/" . $serie->logoSrc))
        ) {
            throw new Exception('The provided logoSrc is not a valid file in the storage directory.');
        }

        return $serie;
    }
}
