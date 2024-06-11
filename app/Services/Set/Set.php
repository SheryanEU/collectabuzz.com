<?php

declare(strict_types=1);

namespace App\Services\Set;

use App\Dto\Set as SetDto;
use App\Interfaces\Services\ISet;
use App\Repositories\Set\Set as SetRepository;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final readonly class Set implements ISet
{
    public function __construct(
        protected SetRepository $setRepository
    ) {}

    /**
     * @throws Exception
     */
    public function create(SetDto $set): SetDto
    {
        $set = $this->handleLogoSrc($set);

        return $this->setRepository->create($set);
    }

    /**
     * @throws Exception
     */
    private function handleLogoSrc(SetDto $set): SetDto
    {
        $fileNameBase = Str::slug($set->name, '_');
        $directory = 'public/set/logo';
        $path = "$directory/$fileNameBase";

        if ($set->logoSrc instanceof UploadedFile) {
            $extension = $set->logoSrc->getClientOriginalExtension();
            $fullPath = "$path.$extension";

            if (!Storage::exists($fullPath)) {
                $path = $set->logoSrc->storeAs($directory, "$fileNameBase.$extension");
            }

            $set->logoSrc = Storage::url($fullPath);
        } elseif (
            filter_var($set->logoSrc, FILTER_VALIDATE_URL)
        ) {
            $extension = pathinfo($set->logoSrc, PATHINFO_EXTENSION);
            $fullPath = "$path.$extension";

            if (!Storage::exists($fullPath)) {
                $contents = file_get_contents($set->logoSrc);
                Storage::put($fullPath, $contents);
            }

            $set->logoSrc = Storage::url($fullPath);
        } elseif (
            $set->logoSrc !== null
            && !File::exists(storage_path("app/$directory/" . $set->logoSrc))
        ) {
            throw new Exception('The provided logoSrc is not a valid file in the storage directory.');
        }

        return $set;
    }
}
