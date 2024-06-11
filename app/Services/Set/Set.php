<?php

declare(strict_types=1);

namespace App\Services\Set;

use App\Dto\Set as SetDto;
use App\Interfaces\Services\ISet;
use App\Repositories\Set\Set as SetRepository;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
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
        $set = $this->handleSrc($set, 'logoSrc', 'logo');
        $set = $this->handleSrc($set, 'symbolSrc', 'symbol');

        return $this->setRepository->create($set);
    }

    /**
     * @throws Exception
     */
    private function handleSrc(SetDto $set, string $field, string $type): SetDto
    {
        $fileNameBase = Str::slug($set->name, '_');
        $directory = "public/set/$type";
        $path = "$directory/$fileNameBase";

        $src = $set->$field;

        try {
            if ($src instanceof UploadedFile) {
                $this->handleUploadedFile($set, $path, $directory, $fileNameBase, $field);
            } elseif (filter_var($src, FILTER_VALIDATE_URL)) {
                $this->handleUrl($set, $path, $field);
            } else {
                $this->validateSrcExists($set, $directory, $field);
            }
        } catch (Exception $e) {
            Log::error("Failed to set $type from src: $src", ['exception' => $e]);
            $set->$field = null;
        }

        return $set;
    }


    public function handleUploadedFile(SetDto $set, string $path, string $directory, string $fileBaseName, string $field): SetDto
    {
        $extension = $set->$field->getClientOriginalExtension();
        $fullPath = "$path.$extension";

        if (!Storage::exists($fullPath)) {
            $set->$field->storeAs($directory, "$fileBaseName.$extension");
        }

        $set->$field = Storage::url($fullPath);

        return $set;
    }

    public function handleUrl(SetDto $set, string $path, string $field): SetDto
    {
        $extension = pathinfo($set->$field, PATHINFO_EXTENSION);
        $fullPath = "$path.$extension";

        if (!Storage::exists($fullPath)) {
            $contents = file_get_contents($set->$field);
            Storage::put($fullPath, $contents);
        }

        $set->$field = Storage::url($fullPath);

        return $set;
    }

    /**
     * @throws Exception
     */
    public function validateSrcExists(SetDto $set, string $directory, string $field): bool
    {
        if ($set->$field !== null && !File::exists(storage_path("app/$directory/" . $set->$field))) {
            throw new Exception("The provided $field is not a valid file in the storage directory.");
        }

        return true;
    }
}
