<?php

declare(strict_types=1);

namespace App\Services\Card;

use App\Dto\Weakness;
use App\Repositories\Attack\Attack as AttackRepository;
use App\Dto\Card as CardDto;
use App\Repositories\Subtype\Subtype as SubtypeRepository;
use App\Repositories\Type\Type as TypeRepository;
use App\Interfaces\Services\ICard;
use App\Repositories\Card\Card as CardRepository;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final readonly class Card implements ICard
{
    public function __construct(
        private CardRepository $cardRepository,
        private TypeRepository $typeRepository,
        private SubtypeRepository $subtypeRepository,
        private AttackRepository $attackRepository,
    ){}

    public function create(CardDto $card): CardDto
    {
        $card->types = array_map(function($type) {
            return $this->typeRepository->create($type);
        }, $card->types);

        $card->subtypes = array_map(function($subtype) {
            return $this->subtypeRepository->create($subtype);
        }, $card->subtypes);

        $card->attacks = array_map(function($attack) {
            return $this->attackRepository->create($attack);
        }, $card->attacks);

        if ($card->weaknesses) {
            $card->weaknesses = array_map(function ($weakness) {
                $type = $this->typeRepository->create($weakness->type);
                return new Weakness($type, $weakness->value);
            }, $card->weaknesses);
        }

        $card = $this->handleSrc($card, 'thumbnail', 'thumbnail');
        $card = $this->handleSrc($card, 'image', 'image');

        return $this->cardRepository->create($card);
    }

    /**
     * @throws Exception
     */
    private function handleSrc(CardDto $card, string $field, string $type): CardDto
    {
        $fileNameBase = Str::slug($card->cardId . ' ' . $card->name, '_');
        $directory = "public/card/$type";
        $path = "$directory/$fileNameBase";

        $src = $card->$field;

        try {
            if ($src instanceof UploadedFile) {
                $this->handleUploadedFile($card, $path, $directory, $fileNameBase, $field);
            } elseif (filter_var($src, FILTER_VALIDATE_URL)) {
                $this->handleUrl($card, $path, $field);
            } else {
                $this->validateSrcExists($card, $directory, $field);
            }
        } catch (Exception $e) {
            Log::error("Failed to set $type from src: $src", ['exception' => $e]);
            $card->$field = null;
        }

        return $card;
    }


    public function handleUploadedFile(CardDto $card, string $path, string $directory, string $fileBaseName, string $field): CardDto
    {
        $extension = $card->$field->getClientOriginalExtension();
        $fullPath = "$path.$extension";

        if (!Storage::exists($fullPath)) {
            $card->$field->storeAs($directory, "$fileBaseName.$extension");
        }

        $card->$field = Storage::url($fullPath);

        return $card;
    }

    public function handleUrl(CardDto $card, string $path, string $field): CardDto
    {
        $extension = pathinfo($card->$field, PATHINFO_EXTENSION);
        $fullPath = "$path.$extension";

        if (!Storage::exists($fullPath)) {
            $contents = file_get_contents($card->$field);
            Storage::put($fullPath, $contents);
        }

        $card->$field = Storage::url($fullPath);

        return $card;
    }

    /**
     * @throws Exception
     */
    public function validateSrcExists(CardDto $card, string $directory, string $field): bool
    {
        if ($card->$field !== null && !File::exists(storage_path("app/$directory/" . $card->$field))) {
            throw new Exception("The provided $field is not a valid file in the storage directory.");
        }

        return true;
    }
}
